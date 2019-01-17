<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Logement;
use App\Entity\Reservation;
use App\Form\LogementType;
use App\Entity\Ville;
use App\Entity\Photo;
use App\Entity\ParametresLogement;
use App\Entity\ParametresType;
use App\Entity\TypePaiement;
use App\Entity\TypeLogement;

Class LogementController extends AbstractController {

    /**
     * @Route("/logement/{id}", name="logement_index")con
     */
    public function index(Int $id, Request $request) {
        $logement = $this->getDoctrine()->getRepository(Logement::class)->findOneBy(['id' => $id]);
        if(!empty($logement)) {
            if($logement->getEtat() === true) {
            return $this->render('logement/index.html.twig', [
                'logement' => $logement,
                'photos' => $logement->getPhotos()
            ]);
            } else {
                return $this->redirectToRoute('rechercheCategorie_route', array('type' => $logement->getIdType()->getId()));
            }
        } else {
            return $this->redirectToRoute('home_route');
        }    
    }

    /**
     * @Route("/logement/{id}/reservation", name="logement_reservation")
     * @Security("has_role('ROLE_USER')")
     */
    public function reservation(Int $id) {
        $logement = $this->getDoctrine()->getRepository(Logement::class)->findOneBy(['id' => $id]);
        return $this->render('logement/reservation.html.twig', [
            'logement' => $logement
        ]);
    }

    /**
     * @Route("/payer/{id}", name="paiement_route")
     * @Security("has_role('ROLE_USER')")
     */
    public function paiement(Request $request, Logement $logement, \Swift_Mailer $mailer) {
        if(!empty($request->request->get('dateDebut')) && !empty($request->request->get('dateFin'))) {
            $dateDebut = new \DateTime($this->dateFrToIso($request->request->get('dateDebut')));
            $dateFin = new \DateTime($this->dateFrToIso($request->request->get('dateFin')) . ' 23:00:00');
            $today = new \DateTime(date('Y-m-d H:i:s'));
            if(($dateDebut > $today) && ($dateFin > $today)) {
                if ($dateDebut->diff($dateFin)->format('%R%a') > 0) {
                    \Stripe\Stripe::setApiKey("sk_test_3lLQ5AiZpJxagEIuatnEhiNe");                
                    $charge = \Stripe\Charge::create([
                        "amount" => $request->request->get('prixTotal') * 100,
                        "currency" => "eur",
                        "source" => $request->request->get('stripeToken'),
                        "description" => "Réservation Atypik'House " . date('d/m/y H:i:s'),
                        'receipt_email' => trim($this->getUser()->getEmail())
                    ]);
                    if(!empty($charge) && $charge->status == 'succeeded') {
                        $res = new Reservation();
                        $res->setLogement($logement);
                        $res->setUtilisateur($this->getUser());
                        $res->setDateCreation($today);
                        $res->setDateDebut($dateDebut);
                        $res->setDateFin($dateFin);
                        $res->setNbPersonne($request->request->get('nbPersonne'));
                        $res->setPrixTotal($request->request->get('prixTotal'));
                        $res->setTokenPaiement($charge->id);
                        $res->setMode($this->getDoctrine()->getRepository(TypePaiement::class)->findOneBy(['id' => 1]));
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($res);
                        $entityManager->flush();
                        $this->mailPayer($mailer,
                            array(
                                'resa' => $res,
                                'email' => $this->getUser()->getEmail()
                            )
                        );
                        $this->addFlash('success', 'Réservation enregistrée. Vous allez recevoir un récapitulatif d\'ici peu.');
                        return $this->redirectToRoute('logement_index', array('id' => $logement->getId()));
                    } else {
                        $this->addFlash('error', 'Paiement refusé.');
                    }     
                } else {
                    $this->addFlash('error', 'Attention à la cohérence des dates.');
                }
            } else {
                $this->addFlash('error', 'Attention : vous ne pouvez pas réserver à des dates passées.');
            }
        }
        $this->addFlash('error', 'Veuillez rentrez des dates de début et de fin.');
        return $this->render('logement/reservation.html.twig', [
            'logement' => $logement
        ]);        
    }

    /**
     * Permet de convertir une date Fr en Iso
     * @param string $_date
     * @return string
     */
    private function dateFrToIso($_date) {
        $newDate = '';
        if(!empty($_date)) {
            $ymd = explode('/', $_date);
            $newDate = $ymd[2] . '-' . $ymd[1] . '-' . $ymd[0];
        }
        return $newDate;    
    }

    /**
     * @Route("/ajout-logement", name="logement_ajout")
     * @Security("has_role('ROLE_USER')")
     */
    public function proposerLogement(Request $request,\Swift_Mailer $mailer) {
        $logement = new Logement();
        $logement->setIdProprietaire($this->getUser());
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($logement);
                //ajout de la ville
                if(!empty($request->request->get('logement_ville'))) {
                    $ville = $this->getDoctrine()->getRepository(Ville::class)->findOneBy(['nom' => trim($request->request->get('logement_ville'))]);
                    if(!empty($ville)) {
                        $logement->setVille($ville);
                    }
                }
                //ajout des parametres
                if(!empty($request->request->get('params'))) {
                    $params = $request->request->get('params');
                    foreach($params as $k => $v) {
                        $p = new ParametresLogement();
                        $p->setLogement($logement);
                        $p->setParametre($this->getDoctrine()->getRepository(ParametresType::class)->findOneBy(['id' => $k]));
                        $p->setValeur($v);
                        $em->persist($p);
                        $em->flush();
                        $logement->addParametre($p); 
                        $em->persist($logement);                  
                    }
                }
                //ajout des photos
                foreach($logement->getPhotosUploads() as $file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('uploads_directory') . '/' . $logement->getId(),
                        $fileName
                    );
                    $photo = new Photo();
                    $photo->setPhoto($fileName);
                    $photo->setIdLogement($logement);
                    $em->persist($photo);
                    $em->flush();
                    $logement->addPhoto($photo);
                }           
                $em->persist($logement);     
                $em->flush();
                $this->addFlash('success', 'Logement ajouté avec succès. Vous allez recevoir un mail dés lors que votre bien sera validé par notre équipe.');
               //envoi de mail
               $result = $this->mailAjout($mailer, array(
                    'email' => $this->getUser()->getEmail(),
                    'prenom' => $this->getUser()->getPrenom()
                ));
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('error', 'L\'ajout du logement a rencontré un problème.');
            }
        }
        return $this->render('logement/ajout-logement.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * Permet d'envoyer un mail au proprio dés qu'un bien est proposé
     */
    public function mailAjout(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Atypik'House - Vous avez ajouté un logement"))
            ->setFrom('equipe@atypikhouse.fr')
            ->setTo($_data['email'])
            ->setBody(
                $this->renderView(
                    'emails/ajout-logement.html.twig',
                    array(
                        'prenom' => $_data['prenom']
                    )
                ),
                'text/html'
            )
        ;
        return $mailer->send($message);
    }

    /**
     * Permet d'envoyer un mail récapitulatif au locataire
     */
    public function mailPayer(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Atypik'House - Réservation n° " . $_data['resa']->getId()))
            ->setFrom('equipe@atypikhouse.fr')
            ->setTo($_data['email'])
            ->setBody(
                $this->renderView(
                    'emails/reservation.html.twig',
                    array(
                        'resa' => $_data['resa']
                    )
                ),
                'text/html'
            )
        ;
        return $mailer->send($message);
    }

    /**
     * @Route("/categorie-logement/{type}", name="rechercheCategorie_route")
     */
    public function rechercheLogement(int $type){
        $data = array(
            'type' => $type,
            'ville' => '',
            'nb' => 1,
            'depart' => date('d/m/Y'),
            'arrivee' => date('d/m/Y', strtotime('+1 day'))
        );
        return $this->render('home/recherche.html.twig', [
            'types' => $this->getDoctrine()->getRepository(TypeLogement::class)->findAll(),
            'data' => $data,
            'logements' => $this->getDoctrine()->getRepository(Logement::class)->findByCriteres(array('type' => $type, 'nb' => 1, 'etat' => 1))
        ]);
    }
}
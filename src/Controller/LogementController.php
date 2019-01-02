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

Class LogementController extends AbstractController {

    /**
     * @Route("/logement/{id}", name="logement_index")
     */
    public function index(Int $id, Request $request) {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->findOneBy(['id' => $id]);
        return $this->render('logement/index.html.twig', [
            'logement' => $logement
        ]);
    }

    /**
     * @Route("/logement/{id}/reservation", name="logement_reservation")
     */
    public function reservation(Int $id, Request $request) {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->findOneBy(['id' => $id]);
        if(!empty($request->request->get('dateDebut')) && !empty($request->request->get('dateFin'))) {
            $dateDebut = new \DateTime($this->dateFrToIso($request->request->get('dateDebut')));
            $dateFin = new \DateTime($this->dateFrToIso($request->request->get('dateFin')) . ' 23:00:00');
            $today = new \DateTime(date('Y-m-d H:i:s'));
            if($dateDebut->diff($dateFin)->format('%R%a') > 0) {
                $user = $this->getUser();
                $res = new Reservation();
                $res->setLogement($logement);
                $res->setUtilisateur($user);
                $res->setDateCreation($today);
                $res->setDateDebut($dateDebut);
                $res->setDateFin($dateFin);
                $res->setNbPersonne($request->request->get('nbPersonne'));            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($res);
                $entityManager->flush();
            } else {
                $this->addFlash('error', 'Attention à la cohérence des dates.');
            }
        } else {
            $this->addFlash('error', 'Veuillez rentrez des dates de début et de fin.');
        }        
        $this->addFlash('success', 'Réservation enregistrée.');
        return $this->redirectToRoute('logement_index', array('id' => $id));
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
    public function proposerLogement(Request $request) {
        $logement = new Logement();
        $logement->setIdProprietaire($this->getUser());
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($logement);
                $em->flush();
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
                }
                if(!empty($request->request->get('params'))) {
                    $params = $request->request->get('params');
                    foreach($params as $k => $v) {
                        $p = new ParametresLogement();
                        $p->setLogement($logement);
                        $p->setParametre($this->getDoctrine()->getRepository(ParametresType::class)->findOneBy(['id' => $k]));
                        $p->setValeur($v);
                        $logement->addParametre($p);
                        $em->persist($p);
                        $em->flush();                   
                    }
                }
                $this->addFlash('success', 'Logement ajouté avec succès. Vous allez recevoir un mail dés lors que votre bien sera validé par notre équipe.');
                $result = $this->sendMail($mailer, array(
                    'email' => $user->getEmail(), 
                    'token' => $user->getTokenUser(), 
                    'prenom' => $user->getPrenom()
                ));
                return $this->redirectToRoute('logement_liste');
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
    public function sendMail(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Atypik\'House - Vous avez ajouté un logement"))
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

}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;
use App\Entity\Logement;
use App\Entity\Ville;
use App\Form\ContactType;
use Symfony\Component\Validator\Constraints\DateTime;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_route")
     */
    public function index(Request $request) {
        return $this->render('home/index.html.twig', [
            'types' => $this->getDoctrine()->getRepository(TypeLogement::class)->findAll(),
            'data' => array('type' => 0, 'ville' => '', 'nb' => 1, 'depart' => date('d/m/Y'),'arrivee' => date('d/m/Y', strtotime('+1 day')))
        ]);
    }

    /**
     * @Route("/recherche", name="recherche_route")
     */
    public function recherche(Request $request) {
        $data = array(
            'type' => (!empty($request->request->get('type'))) ? $request->request->get('type') : 0,
            'ville' => '',
            'nb' => (!empty($request->request->get('nb'))) ? $request->request->get('nb') : 1,
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y', strtotime('+1 day'))
        );        
        $repoSearch = $this->getDoctrine()->getRepository(Logement::class);
        if(!empty($request->request->get('ville'))) {
            $data['ville'] = $request->request->get('ville');
            $ville = $this->getDoctrine()->getRepository(Ville::class)->findOneBy(['nom' => $data['ville']]);
            if(!empty($ville)) {
                $logements = $repoSearch->findByCriteresAndVille(array('type' => $data['type'], 'nb' => $data['nb'], 'etat' => 1, 'ville' => $ville));
            }
        } else {
            $logements = $repoSearch->findByCriteres(array('type' => $data['type'], 'nb' => $data['nb'], 'etat' => 1));
        }        
        return $this->render('home/recherche.html.twig', [
            'types' => $this->getDoctrine()->getRepository(TypeLogement::class)->findAll(),
            'data' => $data,
            'logements' => $logements
        ]);
    }

    /**
     * @Route("/contact", name="contact_route")
     */
    public function contact(Request $request, \Swift_Mailer $mailer) {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $data = $form->getData();
            if(empty($data['captcha'])) {
                $send = $this->sendMail($mailer, $data);
                if($send) {
                    $this->addFlash('success', 'Votre message a bien été envoyé.');                    
                    return $this->redirectToRoute('contact_route');
                } else {
                    $this->addFlash('error', 'Une erreur est survenue lors de l\'envoi de votre message.');
                }
            }
        }
        return $this->render('home/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet d'envoyer un mail à travers le formulaire de contact
     */
    private function sendMail(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Atypik'House - Formulaire de contact"))
            ->setFrom($_data['email'])
            ->setTo('contact@atypikhouse.fr')
            ->setBody(
                $this->renderView(
                    'emails/contact-mail.html.twig',
                    array(
                        'prenom' => $_data['prenom'],
                        'nom' => $_data['nom'],
                        'telephone' => $_data['telephone'],
                        'email' => $_data['email'],
                        'sujet' => $_data['sujet'],
                        'message' => $_data['message'],
                    )
                ),
                'text/html'
            )
        ;
        return $mailer->send($message);
    }
}

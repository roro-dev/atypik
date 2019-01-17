<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;
use App\Entity\Logement;
use App\Form\ContactType;
use Symfony\Component\Validator\Constraints\DateTime;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home_route")
     */
    public function index(Request $request) {
        $t = $this->getDoctrine()->getRepository(Logement::class)->findOneBy(['id' => 4]);
        echo count($t->getReservations());
        $today = new \DateTime(date('Y-m-d H:i:s'));
        foreach($t->getReservations() as $r) {
            if($today >= $r->getDateDebut() && $today <= $r->getDateFin()) {
                echo 'c"est diie';
                break;
            } else {
                echo 'c"est good';
            }
        }
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
            'ville' => (!empty($request->request->get('ville'))) ? $request->request->get('ville') : '',
            'nb' => (!empty($request->request->get('nb'))) ? $request->request->get('nb') : 1,
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y', strtotime('+1 day'))
        );
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        $repoSearch = $this->getDoctrine()->getRepository(Logement::class);
        $logements = $repoSearch->findByCriteres(array('type' => $request->request->get('type'), 'nb' => $request->request->get('nb'), 'etat' => 1));
        return $this->render('home/recherche.html.twig', [
            'types' => $repo->findAll(),
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

    private function sendMail(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Atypik'House - Formulaire de contact"))
            ->setFrom('contact@atypikhouse.fr')
            ->setTo('stefane.rodrigues@aefinfo.fr')
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

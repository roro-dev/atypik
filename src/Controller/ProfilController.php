<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Form\ProfilType;
use App\Entity\Utilisateur;
use App\Entity\Message;

Class ProfilController extends AbstractController {

    /**
     * @Route("/profil", name="profil", methods="post|get")
     * @Security("has_role('ROLE_USER')")
     */
    public function index(Request $request) {
        
        $form = $this->createForm(ProfilType::class, $this->getUser());
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $this->addFlash('success', 'Vos informations ont bien été mises à jour.');
            } else {
                //$this->addFlash('error', 'Une erreur est survenue. Veuillez contactez l\'administrateur du site.');
            }
        }
        return $this->render('home/profil.html.twig', [
            'newResas' => $this->getDoctrine()->getRepository(Reservation::class)->findProchainesReservations($this->getUser(), date('Y-m-d')),
            'oldResas' => $this->getDoctrine()->getRepository(Reservation::class)->findAnciennesReservations($this->getUser(), date('Y-m-d')),
            'form' => $form->createView()
        ]);
    }

    /**
     * Permet de repondre aux messages reçus
     * @Route("/repondre-message/{id}", name="reponse_route", methods="post")
     */
    public function repondreMessage(Message $message, Request $request) {
        if(!empty($request->request->get('objet')) && !empty($request->request->get('contenu'))) {
            $em = $this->getDoctrine()->getManager();
            $dest = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['email' => $message->getExpediteur()]);
            $mess = new Message();
            $mess->setDestinataire($dest);
            $mess->setExpediteur($this->getUser()->getEmail());
            $mess->setLogement($message->getLogement());
            $mess->setObjet($request->request->get('objet'));
            $mess->setContenu($request->request->get('contenu'));
            $today = new \DateTime(date('Y-m-d H:i:s'));
            $mess->setDateEnvoi($today);
            $em->persist($mess);
            $em->flush();
            $this->addFlash('success', 'Votre réponse a bien été envoyé.');            
            return $this->redirectToRoute('profil');
        }
    }
}
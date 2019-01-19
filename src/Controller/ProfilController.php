<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Reservation;
use App\Form\ProfilType;

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
                $this->addFlash('success', 'Votre compte à bien été modifié.');
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
}
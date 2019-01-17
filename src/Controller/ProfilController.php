<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use App\Entity\Reservation;

Class ProfilController extends AbstractController {

    /**
     * @Route("/profil", name="profil")
     * @Security("has_role('ROLE_USER')")
     */
    public function index() {
        return $this->render('home/profil.html.twig', [
            'newResas' => $this->getDoctrine()->getRepository(Reservation::class)->findProchainesReservations($this->getUser(), date('Y-m-d')),
            'oldResas' => $this->getDoctrine()->getRepository(Reservation::class)->findAnciennesReservations($this->getUser(), date('Y-m-d'))

        ]);
    }
}
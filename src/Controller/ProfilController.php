<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Entity\RolesUtilisateur;

Class ProfilController extends AbstractController {

    /**
     * @Route("/profil", name="profil")
     */
    public function index() {
        return $this->render('home/profil.html.twig', [
            'reservations' => $this->getUser()->getReservations()
        ]);
    }
}
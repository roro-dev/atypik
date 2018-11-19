<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Entity\RolesUtilisateur;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repoLogement = $this->getDoctrine()->getRepository(RolesUtilisateur::class);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }

    /**
     * @Route("/recherche", name="recherche_route")
     */
    public function recherche()
    {
        $repoLogement = $this->getDoctrine()->getRepository(RolesUtilisateur::class);
        return $this->render('home/recherche.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }
}

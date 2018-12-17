<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        return $this->render('home/index.html.twig', [
            'types' => $repo->findAll()
        ]);
    }

    /**
     * @Route("/recherche", name="recherche_route")
     */
    public function recherche()
    {
        return $this->render('home/recherche.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }

    /**
     * @Route("/produit", name="produit_route")
     */
    public function produit()
    {
        return $this->render('home/produit.html.twig', [
            'controller_name' => 'HomeController'
        ]);
    }
}

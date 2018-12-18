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
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        return $this->render('home/recherche.html.twig', [
            'types' => $repo->findAll()
        ]);
    }
}

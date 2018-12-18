<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Logement;

Class LogementController extends AbstractController {

    /**
     * @Route("/logement/{id}", name="logement_index")
     */
    public function index(Int $id) {        
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->findOneBy(['id' => $id]);
        return $this->render('logement/index.html.twig', [
            'logement' => $logement
        ]);
    }

}
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use App\Entity\Logement;
use App\Entity\Reservation;

Class LogementController extends AbstractController {

    /**
     * @Route("/logement/{id}", name="logement_index")
     */
    public function index(Int $id, Request $request) {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->findOneBy(['id' => $id]);
        return $this->render('logement/index.html.twig', [
            'logement' => $logement
        ]);
    }

    /**
     * @Route("/logement/{id}/reservation", name="logement_reservation")
     */
    public function reservation(Int $id, Request $request) {
        $repo = $this->getDoctrine()->getRepository(Logement::class);
        $logement = $repo->findOneBy(['id' => $id]);
        if($request->request->get('nbPersonne') <= $logement.nbPersonne) {
            $res = new Reservation();
            
        } else {

        }
        return $this->render('logement/index.html.twig', [
            'logement' => $logement
        ]);
    }

}
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
        if(!empty($request->request->get('dateDebut')) && !empty($request->request->get('dateFin'))) {
            $dateDebut = new \DateTime($this->dateFrToIso($request->request->get('dateDebut')));
            $dateFin = new \DateTime($this->dateFrToIso($request->request->get('dateFin')) . ' 23:00:00');
            $today = new \DateTime(date('Y-m-d H:i:s'));
            if($dateDebut->diff($dateFin)->format('%R%a') > 0) {
                $user = $this->getUser();
                $res = new Reservation();
                $res->setLogement($logement);
                $res->setUtilisateur($user);
                $res->setDateCreation($today);
                $res->setDateDebut($dateDebut);
                $res->setDateFin($dateFin);
                $res->setNbPersonne($request->request->get('nbPersonne'));            
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($res);
                $entityManager->flush();
            } else {
                $this->addFlash('error', 'Attention à la cohérence des dates.');
            }
        } else {
            $this->addFlash('error', 'Veuillez rentrez des dates de début et de fin.');
        }        
        $this->addFlash('success', 'Réservation enregistrée.');
        return $this->redirectToRoute('logement_index', array('id' => $id));
    }

    /**
     * Permet de convertir une date Fr en Iso
     * @param string $_date
     * @return string
     */
    private function dateFrToIso($_date) {
        $newDate = '';
        if(!empty($_date)) {
            $ymd = explode('/', $_date);
            $newDate = $ymd[2] . '-' . $ymd[1] . '-' . $ymd[0];
        }
        return $newDate;    
    }

}
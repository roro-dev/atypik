<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;
use App\Entity\Logement;
use App\Entity\Ville;


/**
 * @Route("/ville")
 */
class VilleController extends AbstractController {
    
    /**
     * @Route("/getVilles", name="ajax_getville", methods="POST")
     * Permet de récupérer les ville par rapport à un char recherché
     * @return  JSON | String
     */
    public function getVilles(Request $request) {
        if(!empty($request->request->get('term'))) {
            $villes = $this->getDoctrine()->getRepository(Ville::class)->findByTerm($request->request->get('term'));
            return new Response(json_encode($villes));
        } else {
            return new Response("Erreur");
        }        
    }

}






    
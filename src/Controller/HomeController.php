<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request) {
        $data = array(
            'type' => (!empty($request->request->get('type'))) ? $request->request->get('type') : 0,
            'ville' => (!empty($request->request->get('ville'))) ? $request->request->get('ville') : '',
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y'),
        );
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        return $this->render('home/index.html.twig', [
            'types' => $repo->findAll(),
            'data' => $data
        ]);
    }

    /**
     * @Route("/recherche", name="recherche_route")
     */
    public function recherche(Request $request) {
        $data = array(
            'type' => (!empty($request->request->get('type'))) ? $request->request->get('type') : 0,
            'ville' => (!empty($request->request->get('ville'))) ? $request->request->get('ville') : '',
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y'),
        );
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        return $this->render('home/recherche.html.twig', [
            'types' => $repo->findAll(),
            'data' => $data
        ]);
    }
}

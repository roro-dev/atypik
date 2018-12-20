<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Entity\TypeLogement;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Logement;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(Request $request) {
        $data = array(
            'type' => (!empty($request->request->get('type'))) ? $request->request->get('type') : 0,
            'ville' => (!empty($request->request->get('ville'))) ? $request->request->get('ville') : '',
            'nb' => (!empty($request->request->get('nb'))) ? $request->request->get('nb') : '',
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y', strtotime('+1 day'))
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
            'nb' => (!empty($request->request->get('nb'))) ? $request->request->get('nb') : '',
            'depart' => (!empty($request->request->get('depart'))) ? $request->request->get('depart') : date('d/m/Y'),
            'arrivee' => (!empty($request->request->get('arrivee'))) ? $request->request->get('arrivee') : date('d/m/Y', strtotime('+1 day'))
        );
        $repo = $this->getDoctrine()->getRepository(TypeLogement::class);
        $repoSearch = $this->getDoctrine()->getRepository(Logement::class);
        $logements = $repoSearch->findByCriteres(array('type' => $request->request->get('type'), 'nb' => $request->request->get('nb')));
        return $this->render('home/recherche.html.twig', [
            'types' => $repo->findAll(),
            'data' => $data,
            'logements' => $logements
        ]);
    }
}

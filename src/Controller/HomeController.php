<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

use App\Logement;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index()
    {
        $repository = $this->getDoctrine()->getRepository(Logement::class);
        $logements = $repository->findAll();
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'logements' => $logements
        ]);
    }

    public function inscription() {

    }

    public function login(AuthenticationUtils $authenticationUtils) {
      // get the login error if there is one
      $error = $authenticationUtils->getLastAuthenticationError();

      // last username entered by the user
      $lastUsername = $authenticationUtils->getLastUsername();

      return $this->render('home/login.html.twig', array(
          'last_username' => $lastUsername,
          'error'         => $error,
      ));
    }

    public function enregistrement() {

    }

    public function deconnexion() {

    }
}

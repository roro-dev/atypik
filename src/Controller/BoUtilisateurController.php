<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;

class BoUtilisateurController extends AbstractController
{
    /**
     * @Route("/bo/utilisateur", name="bo_utilisateur")
     */
    public function liste()
    {

      $repository = $this->getDoctrine()->getRepository(Utilisateur::class);
      $users = $repository->findAll();
        return $this->render('bo/utilisateur/utilisateur-liste.html.twig', [
            'users' => $users,
        ]);
    }
}

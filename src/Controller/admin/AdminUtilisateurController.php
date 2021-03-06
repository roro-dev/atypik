<?php

namespace App\Controller\admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Utilisateur;

class AdminUtilisateurController extends AbstractController
{
    public function liste()
    {
    	$repository = $this->getDoctrine()->getRepository(Utilisateur::class);
		$users = $repository->findAll();

        return $this->render('bo/utilisateur/utilisateur-liste.html.twig', [
            'controller_name' => 'HomeController',
            'users' 		=> $users
        ]);
    }
}

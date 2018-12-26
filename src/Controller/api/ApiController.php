<?php

namespace App\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Utilisateur;

/**
* @Route("/api")
*/
class ApiController extends AbstractController
{

    /**
     * Permet d'authentifier un utilisateur dans l'application
     * @Route("/auth", name="auth_api", methods="post")
     */
    public function connexion_post(Request $request, UserPasswordEncoderInterface $passwordEncoder) {
        if($request->request->get('tokenApi') === 'test') {
            $response = new Response();
            if(!empty($request->request->get('username'))) {
                $user = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['email' => $request->request->get('username')]);
                if(!empty($user) && !empty($request->request->get('password'))) {                    
                    $response->headers->set('Content-Type', 'application/json');    
                    if($passwordEncoder->isPasswordValid($user, $request->request->get('password'))) {
                        $response->setContent(json_encode('Success'));
                    } else {
                        $response->setContent(json_encode('Mot de passe erronné.'));
                    }
                    return $response;
                }
            }
        }
    }
}
    
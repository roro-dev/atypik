<?php

namespace App\Controller\api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\Entity\Utilisateur;
use App\Entity\TypeLogement;

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
        if(!empty($request->request->get('tokenApi')) && $request->request->get('tokenApi') === 'test') {
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

    /**
     * Permet d'obtenir les types de logement dans l'application
     * @Route("/types-logements", name="types_api", methods="post")
     */    
    public function types_logement(Request $request) {
        if(!empty($request->request->get('tokenApi')) && $request->request->get('tokenApi') === 'test') {
            $types = $this->getDoctrine()->getRepository(TypeLogement::class)->findAllTypes();
            $response = new Response();
            $response->headers->set('Content-Type', 'application/json');
            $response->setContent(json_encode($types));
            return $response;
        }
    }
}
    
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use App\Security\LoginFormAuthenticator;
use App\Entity\Utilisateur;
use App\Entity\RolesUtilisateur;
use App\Form\UtilisateurType;

class SecurityController extends AbstractController
{

	/**
     * @Route("/login", name="login_route")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
	    $error = $authenticationUtils->getLastAuthenticationError();
	    $lastUsername = $authenticationUtils->getLastUsername();

	    return $this->render('security/login.html.twig', array(
	        'last_username' => $lastUsername,
	        'error'         => $error,
	    ));
	}

	/**
     * @Route("/register", name="user_registration")
     */
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $repository = $this->getDoctrine()->getRepository(RolesUtilisateur::class);
		$role = $repository->findOneBy(['id' => 1]);
        $user->setIdRole($role);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();                
                $this->addFlash('success', 'Votre compte à bien été enregistré.');
                return $this->redirectToRoute('home_route');
            } else {
                die((string) $form->getErrors());
            }
        }

        return $this->render(
            'security/register.html.twig',
            array('form' => $form->createView())
        );
    }
}
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
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $repository = $this->getDoctrine()->getRepository(RolesUtilisateur::class);
                $role = $repository->findOneBy(['id' => 1]);
                $user->setIdRole($role);
                $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
                $user->setPassword($password);
                $user->setTokenUser = bin2hex(random_bytes(5));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Votre compte à bien été crée. Vous allez recevoir un mail pour valider votre compte.');
                return $this->redirectToRoute('home_route');
            } else {
                $this->addFlash('error', 'La création de compte a connu certains problèmes.');
                //$error = $form->getErrors();
            }
        }

        return $this->render(
            'security/register.html.twig',
            array(
                'form'  => $form->createView()
            )
        );
    }

    /**
     * @Route("/test", name="test_mail")
     */
    public function test(\Swift_Mailer $mailer)
    {
    $message = (new \Swift_Message('Hello Email'))
        ->setFrom('send@example.com')
        ->setTo('stefanerodrigues75010@examgmail.com')
        ->setBody('Test vous etes inscrit')
        /*
         * If you also want to include a plaintext version of the message
        ->addPart(
            $this->renderView(
                'emails/registration.txt.twig',
                array('name' => $name)
            ),
            'text/plain'
        )
        */
    ;

    $mailer->send($message);
    return $this->render('home/index.html.twig');
}
}
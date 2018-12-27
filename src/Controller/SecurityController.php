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
    public function register(LoginFormAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UtilisateurType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $role = $this->getDoctrine()->getRepository(RolesUtilisateur::class)->findOneBy(['id' => 2]);
                $user->setRole($role);
                $user->setPassword($passwordEncoder->encodePassword($user, $user->getPlainPassword()));
                $user->setTokenUser(bin2hex(random_bytes(5)));
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();
                $this->addFlash('success', 'Votre compte à bien été crée. Vous allez recevoir un mail pour valider votre compte.');                
                $result = $this->sendMail($mailer, array(
                    'email' => $user->getEmail(), 
                    'token' => $user->getTokenUser(), 
                    'prenom' => $user->getPrenom()
                ));
                if($result) {
                    $this->addFlash('success', 'Mail good.');
                } else {
                    $this->addFlash('error', 'Erreur mail.');
                }
                return $this->redirectToRoute('home');
            } else {
                $this->addFlash('error', 'La création de compte a connu certains problèmes.');
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
     * Permet d'envoyer le mail d'inscription afin de pouvoir se connecter
     */
    public function sendMail(\Swift_Mailer $mailer, $_data)
    {
        $message = (new \Swift_Message("Confirmation d'adresse mail"))
            ->setFrom('stefanedr.dev@gmail.com')
            ->setTo($_data['email'])
            ->setBody(
                $this->renderView(
                    'emails/inscription.html.twig',
                    array(
                        'prenom' => $_data['prenom'],
                        'token' => $_data['token']
                    )
                ),
                'text/html'
            )
        ;
        return $mailer->send($message);
    }

    /**
     * @Route("/validation/{token}", name="validate_user")
     * Fonction pour valider un compte d'utilisateur via un token
     */
    public function validerUser(String $token) {        
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class);
        $user = $repo->findOneBy(['tokenUser' => $token]);
        if(!empty($user)) {
            $user->setValideUser(1);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('success', 'Votre compte a été validé. Vous pouvez vous connecter.');
            return $this->redirectToRoute('login_route');
        } else {
            $this->addFlash('error', 'La validation du compte a connu certains problèmes ...<br>Veuillez contactez l\'administrateur du site.');
            return $this->render('home/index.html.twig');
        }        
    }
}
<?php

namespace App\Controller\admin;

use App\Entity\Logement;
use App\Form\TypeLogementType;
use App\Form\LogementType;
use App\Repository\LogementRepository;
use App\Repository\TypeLogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Entity\ParametresLogement;
use App\Entity\ParametresType;
use App\Entity\Ville;
use App\Entity\Photo;

/**
 * @Route("/admin/logement")
 */
class AdminLogementController extends AbstractController
{
    /**
     * @Route("/", name="logement_liste", methods="GET")
     */
    public function liste(LogementRepository $logementRepository): Response
    {
        return $this->render('admin/logement/logement-liste.html.twig', ['logements' => $logementRepository->findAll()]);
    }

    /**
     * @Route("/new", name="logement_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        
        $logement = new Logement();
        $repo = $this->getDoctrine()->getRepository(Utilisateur::class)->findOneBy(['id' => 1]);
        $logement->setIdProprietaire($repo);
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                foreach($logement->getPhotosUploads() as $file) {
                    $fileName = md5(uniqid()).'.'.$file->guessExtension();
                    $file->move(
                        $this->getParameter('uploads_directory') . '/' . $logement->getId(),
                        $fileName
                    );
                    $photo = new Photo();
                    $photo->setPhoto($fileName);
                    $photo->setIdLogement($logement);
                    $em->persist($photo);
                    $em->flush();
                }
                if(!empty($request->request->get('params'))) {
                    $params = $request->request->get('params');
                    foreach($params as $k => $v) {
                        $p = new ParametresLogement();
                        $p->setLogement($logement);
                        $p->setParametre($this->getDoctrine()->getRepository(ParametresType::class)->findOneBy(['id' => $k]));
                        $p->setValeur($v);
                        $logement->addParametre($p);
                        $em->persist($p);
                        $em->flush();                   
                    }
                }
                $em->persist($logement);
                $em->flush();
                $this->addFlash('success', 'Logement crée avec succès.');
                return $this->redirectToRoute('logement_liste');
            } else {                
                $this->addFlash('error', 'La création du logement a rencontré un problème.');
            }
        }

        return $this->render('admin/logement/logement-new.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="logement_apercu", methods="GET")
     */
    public function show(Logement $logement): Response
    {
        return $this->render('admin/logement/logement-apercu.html.twig', ['logement' => $logement]);
    }

    /**
     * @Route("/edit/{id}", name="logement_edit", methods="GET|POST")
     */
    public function edit(Request $request, Logement $logement): Response
    {
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);        
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Logement bien mis à jour.');
            } else {                
                $this->addFlash('error', 'La création du logement a rencontré un problème.');
            }
        }
        return $this->render('admin/logement/logement-edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
            'params' => $logement->getParametres()
        ]);
    }

    public function delete(Request $request, Logement $logement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($logement);
            $em->flush();
        }
        return $this->redirectToRoute('logement_index');
    }

    /**
     * @Route("/desactiver/{id}", name="logement_desactiver", methods="GET|POST")
     */
    public function desastiverLogement(Logement $logement): Response {
        if($logement->getEtat() === true) {
            $logement->setEtat(false);
            $em = $this->getDoctrine()->getManager();
            $em->persist($logement);
            $em->flush();
            $this->addFlash('success', 'Le logement "' . $logement->getNom() . '" a bien été désactivé.');
        } else {                
            $this->addFlash('error', 'Ce logement n\'est pas validé.');
        }        
        return $this->redirectToRoute('logement_index');
    }

    /**
     * @Route("/valider/{id}", name="logement_valider", methods="GET|POST")
     */
    public function validerLogement(Logement $logement) : Response {
        if($logement->getEtat() === false) {
            $logement->setEtat(true);
            $em = $this->getDoctrine()->getManager();
            $em->persist($logement);
            $em->flush();
            $this->addFlash('success', 'Le logement "' . $logement->getNom() . '" a bien été validé.');
        } else {                
            $this->addFlash('error', 'Ce logement est déjà validé.');
        }        
        return $this->redirectToRoute('logement_liste');
    }
}

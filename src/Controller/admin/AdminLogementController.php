<?php

namespace App\Controller\admin;

use App\Entity\Logement;
use App\Form\LogementType;
use App\Repository\LogementRepository;
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
        return $this->render('admin/logement/logement-index.html.twig', ['logements' => $logementRepository->findAll()]);
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
                $em->persist($logement);
                $em->flush();
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
     * @Route("/{id}", name="logement_show", methods="GET")
     */
    public function show(Logement $logement): Response
    {
        return $this->render('admin/logement/logement-show.html.twig', ['logement' => $logement]);
    }

    /**
     * @Route("/edit/{id}", name="logement_edit", methods="GET|POST")
     */
    public function edit(Request $request, Logement $logement): Response
    {
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);        
        if ($form->isSubmitted()) {
            //var_dump($logement->getPhotos());die;
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

    /**
     * @Route("/{id}", name="logement_delete", methods="DELETE")
     */
    public function delete(Request $request, Logement $logement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$logement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($logement);
            $em->flush();
        }

        return $this->redirectToRoute('logement_index');
    }
}

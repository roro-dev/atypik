<?php

namespace App\Controller\admin;

use App\Entity\Logement;
use App\Form\LogementType;
use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/logement")
 */
class LogementController extends AbstractController
{
    /**
     * @Route("/", name="logement_index", methods="GET")
     */
    public function index(LogementRepository $logementRepository): Response
    {
        return $this->render('logement/index.html.twig', ['logements' => $logementRepository->findAll()]);
    }

    /**
     * @Route("/new", name="logement_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($logement);
            $em->flush();

            return $this->redirectToRoute('logement_index');
        }

        return $this->render('admin/logement/new.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="logement_show", methods="GET")
     */
    public function show(Logement $logement): Response
    {
        return $this->render('admin/logement/show.html.twig', ['logement' => $logement]);
    }

    /**
     * @Route("/{id}/edit", name="logement_edit", methods="GET|POST")
     */
    public function edit(Request $request, Logement $logement): Response
    {
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('logement_edit', ['id' => $logement->getId()]);
        }

        return $this->render('admin/logement/edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView(),
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

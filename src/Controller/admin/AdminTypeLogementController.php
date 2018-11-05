<?php

namespace App\Controller\admin;

use App\Entity\TypeLogement;
use App\Form\TypeLogementType;
use App\Repository\TypeLogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/typelogement")
 */
class AdminTypeLogementController extends AbstractController
{
    /**
     * @Route("/", name="type_logement_index", methods="GET")
     */
    public function index(TypeLogementRepository $typeLogementRepository): Response
    {
        return $this->render('admin/type-logement/index.html.twig', ['type_logements' => $typeLogementRepository->findAll()]);
    }

    /**
     * @Route("/new", name="type_logement_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $typeLogement = new TypeLogement();
        $form = $this->createForm(TypeLogementType::class, $typeLogement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($typeLogement);
            $em->flush();

            return $this->redirectToRoute('type_logement_index');
        }

        return $this->render('admin/type-logement/new.html.twig', [
            'type_logement' => $typeLogement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_logement_show", methods="GET")
     */
    public function show(TypeLogement $typeLogement): Response
    {
        return $this->render('admin/type-logement/show.html.twig', ['type_logement' => $typeLogement]);
    }

    /**
     * @Route("/edit/{id}", name="type_logement_edit", methods="GET|POST")
     */
    public function edit(Request $request, TypeLogement $typeLogement): Response
    {
        $form = $this->createForm(TypeLogementType::class, $typeLogement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('type_logement_edit', ['id' => $typeLogement->getId()]);
        }

        return $this->render('admin/type-logement/edit.html.twig', [
            'type_logement' => $typeLogement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="type_logement_delete", methods="DELETE")
     */
    public function delete(Request $request, TypeLogement $typeLogement): Response
    {
        if ($this->isCsrfTokenValid('delete'.$typeLogement->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($typeLogement);
            $em->flush();
        }

        return $this->redirectToRoute('type_logement_index');
    }
}

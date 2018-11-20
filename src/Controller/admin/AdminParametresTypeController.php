<?php

namespace App\Controller\admin;

use App\Entity\ParametresType;
use App\Entity\TypeLogement;
use App\Repository\ParametresTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/parametres-type")
 */
class AdminParametresTypeController extends AbstractController
{
    /**
     * @Route("/", name="parametres_type_index", methods="GET")
     */
    public function index(ParametresTypeRepository $repoParams, string $type = null): Response {
        $data = array('type' => $this->getDoctrine()->getRepository(TypeLogement::class)->findAll());
        if(!empty($type)) {
            $data['params'] = $repoParams->findBy(array('type_id' => $type));
        } else {
            $data['params'] = $repoParams->findAll();
        }
        return $this->render(
            'admin/parametres-type/parametres-type-index.html.twig',
            $data
        );
    }

    /**
     * @Route("/new", name="parametres_type_new", methods="GET|POST")
     */
    public function new(Request $request): Response
    {
        $parametresType = new ParametresType();
        $form = $this->createForm(ParametresType::class, $parametresType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($parametresType);
            $em->flush();

            return $this->redirectToRoute('parametres_type_index');
        }

        return $this->render('admin/parametres-type/parametres-type-new.html.twig', [
            'parametres_type' => $parametresType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parametres_type_show", methods="GET")
     */
    public function show(ParametresType $parametresType): Response
    {
        return $this->render('admin/parametres-type/parametres-type-show.html.twig', ['parametres_type' => $parametresType]);
    }

    /**
     * @Route("/{id}/edit", name="parametres_type_edit", methods="GET|POST")
     */
    public function edit(Request $request, ParametresType $parametresType): Response
    {
        $form = $this->createForm(ParametresType::class, $parametresType);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('parametres_type_edit', ['id' => $parametresType->getId()]);
        }

        return $this->render('admin/parametres-type/parametres-type-edit.html.twig', [
            'parametres_type' => $parametresType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="parametres_type_delete", methods="DELETE")
     */
    public function delete(Request $request, ParametresType $parametresType): Response
    {
        if ($this->isCsrfTokenValid('delete'.$parametresType->getId(), $request->request->get('_token'))) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($parametresType);
            $em->flush();
        }

        return $this->redirectToRoute('parametres_type_index');
    }
}

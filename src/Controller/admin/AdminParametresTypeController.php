<?php

namespace App\Controller\admin;

use App\Entity\ParametresType;
use App\Entity\TypeLogement;
use App\Form\ParametresTypeType;
use App\Repository\ParametresTypeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Utilisateur;
use App\Entity\Message;

/**
 * @Route("/admin/parametres-type")
 */
class AdminParametresTypeController extends AbstractController
{
    /**
     * @Route("/liste/{type}", name="parametres_type_liste", methods="GET|POST")
     */
    public function liste($type = null): Response {
        $data = array('types' => $this->getDoctrine()->getRepository(TypeLogement::class)->findAll(), 'typeSelect' => $type);
        if(!empty($type)) {
            $data['params'] = $this->getDoctrine()->getRepository(ParametresType::class)->findBy(array('type' => $type));
        } else {
            $data['params'] = $this->getDoctrine()->getRepository(ParametresType::class)->findAll();
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
        $form = $this->createForm(ParametresTypeType::class, $parametresType);
        $form->handleRequest($request);
        if ($form->isSubmitted()){
            if($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($parametresType);
                $em->flush();
                $logements = $parametresType->getType()->getLogements();
                if(!empty($logements)) {
                    foreach($logements as $l) {                        
                        $mess = new Message();
                        $mess->setDestinataire($l->getIdProprietaire());
                        $mess->setExpediteur('administrateur@atypikhouse.fr');
                        $mess->setLogement($l);
                        $mess->setObjet('Paramètre d\'habitat ajouté');
                        $mess->setContenu($request->request->get('Un paramètre d\'habitat a été ajouté. Veuillez vérifiez vos biens afin de les mettre à jour. Merci'));
                        $today = new \DateTime(date('Y-m-d H:i:s'));
                        $mess->setDateEnvoi($today);
                        $em->persist($mess);
                        $em->flush();
                    }
                }
                $this->addFlash('success', 'Paramètre crée avec succès !');
                return $this->redirectToRoute('parametres_type_index');
            } else {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
        return $this->render('admin/parametres-type/parametres-type-new.html.twig', [
            'parametres_type' => $parametresType,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/show/{id}", name="parametres_type_show", methods="GET")
     */
    public function show(ParametresType $parametresType): Response
    {
        return $this->render('admin/parametres-type/parametres-type-show.html.twig', ['parametres_type' => $parametresType]);
    }

    /**
     * @Route("/edit/{id}", name="parametres_type_edit", methods="GET|POST")
     */
    public function edit(Request $request, ParametresType $parametresType): Response
    {
        $form = $this->createForm(ParametresTypeType::class, $parametresType);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if($form->isValid()) {
                $this->getDoctrine()->getManager()->flush();
                $this->addFlash('success', 'Paramètre modifié avec succès !');
                $logements = $parametresType->getType()->getLogements();
                if(!empty($logements)) {
                    foreach($logements as $l) {                        
                        $mess = new Message();
                        $mess->setDestinataire($l->getIdProprietaire());
                        $mess->setExpediteur('administrateur@atypikhouse.fr');
                        $mess->setLogement($l);
                        $mess->setObjet('Paramètre d\'habitat modifié');
                        $mess->setContenu($request->request->get('Un paramètre d\'habitat a été modifié. Veuillez vérifiez vos biens afin de les mettre à jour. Merci'));
                        $today = new \DateTime(date('Y-m-d H:i:s'));
                        $mess->setDateEnvoi($today);
                        $em->persist($mess);
                        $em->flush();
                    }
                }
                return $this->redirectToRoute('parametres_type_index', array('type' => $parametresType->getType()->getId()));
            } else {
                $this->addFlash('error', 'Une erreur est survenue.');
            }
        }
        return $this->render('admin/parametres-type/parametres-type-edit.html.twig', [
            'parametres_type' => $parametresType,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}", name="parametres_type_delete", methods="DELETE")
     */
    public function delete(Request $request, ParametresType $parametresType): Response
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($parametresType);
        $em->flush();
        $logements = $parametresType->getType()->getLogements();
        if(!empty($logements)) {
            foreach($logements as $l) {                        
                $mess = new Message();
                $mess->setDestinataire($l->getIdProprietaire());
                $mess->setExpediteur('administrateur@atypikhouse.fr');
                $mess->setLogement($l);
                $mess->setObjet('Paramètre d\'habitat supprimé');
                $mess->setContenu($request->request->get('Un paramètre d\'habitat a été supprimé. Veuillez vérifiez vos biens afin de les mettre à jour. Merci'));
                $today = new \DateTime(date('Y-m-d H:i:s'));
                $mess->setDateEnvoi($today);
                $em->persist($mess);
                $em->flush();
            }
        }
        return $this->redirectToRoute('parametres_type_liste');
    }
}

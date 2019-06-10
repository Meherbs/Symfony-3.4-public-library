<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Acteur;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Acteur controller.
 *
 */
class ActeurController extends Controller
{
    /**
     * Lists all acteur entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $acteurs = $em->getRepository('FilmBundle:Acteur')->findAll();
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $acteurs, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',5)/*page number*/
        );
        return $this->render('acteur/index.html.twig', array(
            'acteurs' => $result,
        ));
    }

    /**
     * Creates a new acteur entity.
     *
     */
    public function newAction(Request $request)
    {
        $acteur = new Acteur();
        $form = $this->createForm('FilmBundle\Form\ActeurType', $acteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $acteur->setUpdatedAt(new \DateTime());
            $acteur->setCreatedAt(new \DateTime());
            $em->persist($acteur);
            $em->flush();

            return $this->redirectToRoute('Auteur_index', array('idActeur' => $acteur->getIdacteur()));
        }

        return $this->render('acteur/new.html.twig', array(
            'acteur' => $acteur,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a acteur entity.
     *
     */
    public function showAction(Acteur $acteur)
    {
        $deleteForm = $this->createDeleteForm($acteur);

        return $this->render('acteur/show.html.twig', array(
            'acteur' => $acteur,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing acteur entity.
     *
     */
    public function editAction(Request $request, Acteur $acteur)
    {
        $deleteForm = $this->createDeleteForm($acteur);
        $editForm = $this->createForm('FilmBundle\Form\ActeurType', $acteur);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $acteur->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Auteur_edit', array('idActeur' => $acteur->getIdacteur()));
        }

        return $this->render('acteur/edit.html.twig', array(
            'acteur' => $acteur,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a acteur entity.
     *
     */
    public function deleteAction(Request $request, Acteur $acteur)
    {
        $form = $this->createDeleteForm($acteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($acteur);
            $em->flush();
        }

        return $this->redirectToRoute('Auteur_index');
    }

    /**
     * Creates a form to delete a acteur entity.
     *
     * @param Acteur $acteur The acteur entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Acteur $acteur)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Auteur_delete', array('idActeur' => $acteur->getIdacteur())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

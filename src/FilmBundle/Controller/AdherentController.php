<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Adherent;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Adherent controller.
 *
 */
class AdherentController extends Controller
{
    /**
     * Lists all adherent entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $adherents = $em->getRepository('FilmBundle:Adherent')->findAll();

        return $this->render('adherent/index.html.twig', array(
            'adherents' => $adherents,
        ));
    }

    /**
     * Creates a new adherent entity.
     *
     */
    public function newAction(Request $request)
    {
        $adherent = new Adherent();
        $form = $this->createForm('FilmBundle\Form\AdherentType', $adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $adherent->setUpdatedAt(new \DateTime());
            $adherent->setCreatedAt(new \DateTime());
            $em->persist($adherent);
            $em->flush();

            return $this->redirectToRoute('Adherent_index');
        }

        return $this->render('adherent/new.html.twig', array(
            'adherent' => $adherent,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a adherent entity.
     *
     */
    public function showAction(Adherent $adherent)
    {
        $deleteForm = $this->createDeleteForm($adherent);

        return $this->render('adherent/show.html.twig', array(
            'adherent' => $adherent,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing adherent entity.
     *
     */
    public function editAction(Request $request, Adherent $adherent)
    {
        $deleteForm = $this->createDeleteForm($adherent);
        $editForm = $this->createForm('FilmBundle\Form\AdherentType', $adherent);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $adherent->setUpdatedAt(new \DateTime());
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Adherent_edit', array('idAdherent' => $adherent->getIdadherent()));
        }

        return $this->render('adherent/edit.html.twig', array(
            'adherent' => $adherent,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a adherent entity.
     *
     */
    public function deleteAction(Request $request, Adherent $adherent)
    {
        $form = $this->createDeleteForm($adherent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($adherent);
            $em->flush();
        }

        return $this->redirectToRoute('Adherent_index');
    }

    /**
     * Creates a form to delete a adherent entity.
     *
     * @param Adherent $adherent The adherent entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Adherent $adherent)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Adherent_delete', array('idAdherent' => $adherent->getIdadherent())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
}

<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Categorie;
use FilmBundle\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Categorie controller.
 *
 */
class CategorieController extends Controller
{
    /**
     * Lists all categorie entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $categories = $em->getRepository('FilmBundle:Categorie')->findAll();
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $categories, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',2)/*page number*/
        /*limit per page*/
        );
        return $this->render('categorie/index.html.twig', array(
            'categories' => $result,

        ));
    }

    /**
     * Creates a new categorie entity.
     *
     */
    public function newAction(Request $request)
    {
        $categorie = new Categorie();
        $form = $this->createForm('FilmBundle\Form\CategorieType', $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($categorie);
            $em->flush();

            return $this->redirectToRoute('Categorie_index');
        }

        return $this->render('categorie/new.html.twig', array(
            'categorie' => $categorie,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a categorie entity.
     *
     */
    public function showAction(Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);

        return $this->render('categorie/show.html.twig', array(
            'categorie' => $categorie,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing categorie entity.
     *
     */
    public function editAction(Request $request, Categorie $categorie)
    {
        $deleteForm = $this->createDeleteForm($categorie);
        $editForm = $this->createForm('FilmBundle\Form\CategorieType', $categorie);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Categorie_index');
        }

        return $this->render('categorie/edit.html.twig', array(
            'categorie' => $categorie,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a categorie entity.
     *
     */
    public function deleteAction(Request $request, Categorie $categorie)
    {
        $form = $this->createDeleteForm($categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($categorie);
            $em->flush();
        }

        return $this->redirectToRoute('Categorie_index');
    }

    /**
     * Creates a form to delete a categorie entity.
     *
     * @param Categorie $categorie The categorie entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Categorie $categorie)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Categorie_delete', array('idCategorie' => $categorie->getIdcategorie())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    public function RechercheAction (Request $request, $idCategorie){
        $film = new Film();
        $em= $this->getDoctrine()->getManager();
        $cat = $em->getRepository('FilmBundle:Categorie')->findBy(array('idCategorie' => $idCategorie));

        $filmParCategorie=$em->getRepository('FilmBundle:Film')->findBy(array('categorie'=>$cat));
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $filmParCategorie, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',6)/*page number*/
        /*limit per page*/
        );
        $des = $cat[0]->getDesignCategorie();
        return $this->render('film/index.html.twig', array(
            'films' => $result,
            'category' => $des ,
        ));
    }


}

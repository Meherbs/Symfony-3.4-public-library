<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Film;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


/**
 * Film controller.
 *
 */
class FilmController extends Controller
{
    /**
     * Lists all film entities.
     *
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $films = $em->getRepository('FilmBundle:Film')->findAll();

        /*
         * @var $paginator \knp\Component\Pager\Paginator
         */
        $paginator  = $this->get('knp_paginator');
        $result = $paginator->paginate(
            $films, /* query NOT result */
            $request->query->getInt('page', 1),
            $request->query->getInt('limit',6)/*page number*/
             /*limit per page*/
        );
        return $this->render('film/index.html.twig', array(
            'films' => $result,
            'category' => 'All',
        ));
    }

    /**
     * Creates a new film entity.
     *
     */
    public function newAction(Request $request)
    {
        $film = new Film();
        $form = $this->createForm('FilmBundle\Form\FilmType', $film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $film->setFile($form->get('file'));
            $img = $film->file;
            $uploadedFile = $form->get('file')->getData();
            $file = $uploadedFile->getClientOriginalName();

            // retrieve uploaded files
            $files = $request->files;
            try {
                // and store the file
                $uploadedFil = $files->get('filmbundle_film')["file"];
                $fil = $uploadedFil->move($this->getParameter('uploads_directory'), $file);
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }
            $film->setCouverture($file);
            $em = $this->getDoctrine()->getManager();
            $film->setCreatedAt(new \DateTime());
            $film->setUpdatedAt(new \DateTime());
            $em->persist($film);
            $em->flush();

            return $this->redirectToRoute('Film_index');
        }

        return $this->render('film/new.html.twig', array(
            'film' => $film,
            'form' => $form->createView(),

        ));
    }

    public function filmDispo(){
        $em = $this->getDoctrine()->getManager();
        $film = $em->getRepository('FilmBundle:Film')->findAll();
        return $film;
    }

    /**
     * Finds and displays a film entity.
     *
     */
    public function showAction(Film $film)
    {
        $deleteForm = $this->createDeleteForm($film);

        return $this->render('film/show.html.twig', array(
            'film' => $film,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing film entity.
     *
     */
    public function editAction(Request $request, Film $film)
    {
        $deleteForm = $this->createDeleteForm($film);
        $editForm = $this->createForm('FilmBundle\Form\FilmType', $film);
        $editForm->handleRequest($request);
        $test = 0;
        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $film->setFile($editForm->get('file'));
            $img = $film->file;
            $uploadedFile = $editForm->get('file')->getData();
            $file = $uploadedFile->getClientOriginalName();
            $film->setCouverture($file);
            $film->setUpdatedAt(new \DateTime());
            $em = $this->getDoctrine()->getManager();
            $em->persist($film);
            $em->flush();
            // retrieve uploaded files
            $files = $request->files;
            try {
                // and store the file
                $uploadedFil = $files->get('filmbundle_film')["file"];
                $fil = $uploadedFil->move($this->getParameter('uploads_directory'), $file);


            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            return $this->redirectToRoute('Film_index');
        }

        return $this->render('film/edit.html.twig', array(
            'film' => $film,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a film entity.
     *
     */
    public function deleteAction(Request $request, Film $film)
    {
        $form = $this->createDeleteForm($film);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($film);
            $em->flush();
        }

        return $this->redirectToRoute('Film_index');
    }

    /**
     * Creates a form to delete a film entity.
     *
     * @param Film $film The film entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Film $film)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Film_delete', array('idFilm' => $film->getIdfilm())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

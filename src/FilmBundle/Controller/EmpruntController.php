<?php

namespace FilmBundle\Controller;

use FilmBundle\Entity\Adherent;
use FilmBundle\Entity\Emprunt;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

/**
 * Emprunt controller.
 *
 */
class EmpruntController extends Controller
{
    public function RechercheAction(Request $request, $idAdherent){

    }
    /**
     * Deletes a emprunt entity.
     *
     */
    public function deleteNewAction(Request $request, Emprunt $emprunt)
    {
        $deleteForm = $this->createDelForm($emprunt);

        return $this->render('emprunt/supp.html.twig', array(
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Lists all emprunt entities.
     *
     */
    public function filmNonReturnedAction()
    {
        $em = $this->getDoctrine()->getManager();

        $emprunts = $em->getRepository('FilmBundle:Emprunt')->findBy(array('dhRetour' => null));;

        return $this->render('emprunt/filmNonRetournee.html.twig', array(
            'emprunts' => $emprunts,
        ));
    }
    /**
     * Lists all emprunt entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $emprunts = $em->getRepository('FilmBundle:Emprunt')->findAll();

        return $this->render('emprunt/index.html.twig', array(
            'emprunts' => $emprunts,
        ));
    }

    public function filmIndispoAction(){
        $em = $this->getDoctrine()->getManager();

        $emprunts = $em->getRepository('FilmBundle:Emprunt')->findBy(array('dhRetour' => null));;

        return $this->render('Emprunt/index.html.twig', array(
            'emprunts' => $emprunts,
        ));
    }


    /**
     * Creates a new emprunt entity.
     *
     */
    public function newAction(Request $request)
    {
        $emprunt = new Emprunt();
        $form = $this->createForm('FilmBundle\Form\EmpruntType', $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $emprunt->setDhEmprunt(new \DateTime());
            $em->persist($emprunt);
            $em->flush();
            $adh = $emprunt->getAdherent();

            $emp = $em->getRepository('FilmBundle:Emprunt')->findBy(array('adherent' => $adh));

            return $this->redirectToRoute('Emprunt_add', array('idAdherent' => $adh->getIdAdherent()));
        }

        $emp[] = $emprunt;

        return $this->render('emprunt/new.html.twig', array(
            'emprunt' => $emp,
            'form' => $form->createView(),
        ));
    }

    /**
     * Creates a new emprunt entity.
     *
     */
    public function addAction(Request $request, Adherent $a)
    {
        $emprunt = new Emprunt();
        $form = $this->createForm('FilmBundle\Form\EmpruntType', $emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $emprunt->setAdherent($a);
            $emprunt->setDhEmprunt(new \DateTime());
            $em->persist($emprunt);
            $em->flush();

            $emp = $em->getRepository('FilmBundle:Emprunt')->findBy(array('adherent' => $a));

            return $this->render('emprunt/add.html.twig', array(
                'emprunt' => $emp,
                'form' => $form->createView(),
                'adherent'=> $a,
            ));
        }

        $emp[] = $emprunt;

        return $this->render('emprunt/add.html.twig', array(
            'emprunt' => $emp,
            'form' => $form->createView(),
            'adherent'=> $a,
        ));
    }

    /**
     * Finds and displays a emprunt entity.
     *
     */
    public function showAction(Emprunt $emprunt)
    {
        $deleteForm = $this->createDeleteForm($emprunt);

        return $this->render('emprunt/show.html.twig', array(
            'emprunt' => $emprunt,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing emprunt entity.
     *
     */
    public function editAction(Request $request, Emprunt $emprunt)
    {
        $deleteForm = $this->createDeleteForm($emprunt);
        $editForm = $this->createForm('FilmBundle\Form\EmpruntType', $emprunt);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
           //var_dump($editForm->getData());

            if($editForm->get("dhRetour")->getData()){
                $em = $this->getDoctrine()->getManager();
               $film = $emprunt->getFilm();
               $film->setDisponible(true);
                $em->persist($film);
                $em->flush();
            }
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('Emprunt_edit', array('idEmprunt' => $emprunt->getIdemprunt()));
        }

        return $this->render('emprunt/edit.html.twig', array(
            'emprunt' => $emprunt,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a emprunt entity.
     *
     */
    public function deleteAction(Request $request, Emprunt $emprunt)
    {
        $form = $this->createDeleteForm($emprunt);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($emprunt);
            $em->flush();
        }

        return $this->redirectToRoute('Emprunt_index');
    }

    /**
     * Creates a form to delete a emprunt entity.
     *
     * @param Emprunt $emprunt The emprunt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Emprunt $emprunt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Emprunt_delete', array('idEmprunt' => $emprunt->getIdemprunt())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }
    public function turnAction (Request $request, Adherent $a){
        $emprunt = new Emprunt();
        $form = $this->createForm('FilmBundle\Form\EmpruntType', $emprunt);
        $form->handleRequest($request);
        $em = $this->getDoctrine()->getManager();
        if ($form->isSubmitted() && $form->isValid()) {

            $film = $emprunt->getFilm();
            $emprunt->setDhEmprunt(new \DateTime());
            $emprunt->setAdherent($a);
            $em->persist($emprunt);
            $em->flush();
            $film->getDisponible(false);
            $em->persist($film);
            $em->flush();
            $adh = $emprunt->getAdherent();

            $emp = $em->getRepository('FilmBundle:Emprunt')->findBy(array('adherent' => $adh));

            return $this->render('emprunt/add.html.twig', array(
                'emprunt' => $emp,
                'form' => $form->createView(),
                'adherent'=> $a,
            ));
        }

        $emp = $em->getRepository('FilmBundle:Emprunt')->findBy(array('adherent' => $a));

        return $this->render('emprunt/add.html.twig', array(
            'emprunt' => $emp,
            'form' => $form->createView(),
            'adherent'=> $a,
        ));
    }
    /**
     * Deletes a emprunt entity.
     *
     */
    public function delAction(Request $request, Emprunt $emprunt)
    {
        $form = $this->createDelForm($emprunt);
        $form->handleRequest($request);
        $e = new Emprunt();
        $formadd = $this->createForm('FilmBundle\Form\EmpruntType', $e);
        $em = $this->getDoctrine()->getManager();
        $emp = $em->getRepository('FilmBundle:Emprunt')->findBy(array('adherent' => $emprunt->getAdherent()));
        if ($form->isSubmitted() && $form->isValid()) {
            $ep = $emprunt;
            $em->remove($emprunt);
            $em->flush();
            return $this->redirectToRoute('Emprunt_add', array('idAdherent' => $ep->getAdherent()->getIdAdherent()));
        }
        return $this->render('emprunt/new.html.twig', array(
            'emprunt' => $emp,
            'form' => $formadd->createView(),
        ));

    }



    /**
     * Creates a form to delete a emprunt entity.
     *
     * @param Emprunt $emprunt The emprunt entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDelForm(Emprunt $emprunt)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('Emprunt_del', array('idEmprunt' => $emprunt->getIdEmprunt())))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

}

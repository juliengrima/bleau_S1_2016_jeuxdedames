<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Accueil;
use CmsBundle\Form\AccueilType;

/**
 * Accueil controller.
 *
 */
class AccueilController extends Controller
{
    /**
     * Lists all Accueil entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('CmsBundle:Accueil')->findAll();

        return $this->render('CmsBundle:Accueil:index.html.twig', array(
            'accueils' => $accueils,
        ));
    }

    /**
     * Creates a new Accueil entity.
     *
     */
    public function newAction(Request $request)
    {
        $accueil = new Accueil();
        $form = $this->createForm('CmsBundle\Form\AccueilType', $accueil);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil);
            $em->flush();

            return $this->redirectToRoute('accueil_show', array('id' => $accueil->getId()));
        }

        return $this->render('CmsBundle:Accueil:new.html.twig', array(
            'accueil' => $accueil,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Accueil entity.
     *
     */
    public function showAction(Accueil $accueil)
    {
        $deleteForm = $this->createDeleteForm($accueil);

        return $this->render('CmsBundle:Accueil:show.html.twig', array(
            'accueil' => $accueil,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Accueil entity.
     *
     */
    public function editAction(Request $request, Accueil $accueil)
    {
        $deleteForm = $this->createDeleteForm($accueil);
        $editForm = $this->createForm('CmsBundle\Form\AccueilType', $accueil);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil);
            $em->flush();

            return $this->redirectToRoute('accueil_edit', array('id' => $accueil->getId()));
        }

        return $this->render('CmsBundle:Accueil:edit.html.twig', array(
            'accueil' => $accueil,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Accueil entity.
     *
     */
    public function deleteAction(Request $request, Accueil $accueil)
    {
        $form = $this->createDeleteForm($accueil);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($accueil);
            $em->flush();
        }

        return $this->redirectToRoute('accueil_index');
    }

    /**
     * Creates a form to delete a Accueil entity.
     *
     * @param Accueil $accueil The Accueil entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Accueil $accueil)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('accueil_delete', array('id' => $accueil->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

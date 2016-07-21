<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Presse;
use CmsBundle\Form\PresseType;

/**
 * Presse controller.
 *
 */
class PresseController extends Controller
{
    /**
     * Lists all Presse entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $presses = $em->getRepository('CmsBundle:Presse')->findAll();

        return $this->render('CmsBundle:presse:index.html.twig', array(
            'presses' => $presses,
        ));
    }

    /**
     * Creates a new Presse entity.
     *
     */
    public function newAction(Request $request)
    {
        $presse = new Presse();
        $form = $this->createForm('CmsBundle\Form\PresseType', $presse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($presse);
            $em->flush();

            return $this->redirectToRoute('presse_show', array('id' => $presse->getId()));
        }

        return $this->render('CmsBundle:presse:new.html.twig', array(
            'presse' => $presse,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Presse entity.
     *
     */
    public function showAction(Presse $presse)
    {
        $deleteForm = $this->createDeleteForm($presse);

        return $this->render('CmsBundle:presse:show.html.twig', array(
            'presse' => $presse,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Presse entity.
     *
     */
    public function editAction(Request $request, Presse $presse)
    {
        $deleteForm = $this->createDeleteForm($presse);
        $editForm = $this->createForm('CmsBundle\Form\PresseType', $presse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($editForm->get('file')->getData() != null) {

                if($presse->getImage() != null) {
                    unlink(__DIR__.'/../../../web/uploads/imgcms/'.$presse->getImage());
                    $presse->setImage(null);
                }
            }

            $presse->preUpload();

            $em->persist($presse);
            $em->flush();

            return $this->redirectToRoute('presse_edit', array('id' => $presse->getId()));
        }

        return $this->render('CmsBundle:Presse:edit.html.twig', array(
            'presse' => $presse,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Presse entity.
     *
     */
    public function deleteAction(Request $request, Presse $presse)
    {
        $form = $this->createDeleteForm($presse);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($presse);
            $em->flush();
        }

        return $this->redirectToRoute('presse_index');
    }

    /**
     * Creates a form to delete a Presse entity.
     *
     * @param Presse $presse The Presse entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Presse $presse)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('presse_delete', array('id' => $presse->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

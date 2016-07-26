<?php

namespace CmsBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        $langue = new Presse();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $presse_fr = new Presse();
        $presse_fr->setLangue('fr');
        $langue->getPresse()->add($presse_fr);
        $presse_en = new Presse();
        $presse_en->setLangue('en');
        $langue->getPresse()->add($presse_en);
        $presse_es= new Presse();
        $presse_es->setLangue('es');
        $langue->getPresse()->add($presse_es);

        // end dummy code

        $form = $this->createFormBuilder($langue)
            ->add('presse', CollectionType::class, array(
                'entry_type' => PresseType::class
            ))
            ->add('submit','submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($presse_fr);
            $em->persist($presse_en);
            $em->persist($presse_es);
            $em->flush();

            return $this->redirectToRoute('partenaire_new');
        }

        return $this->render('CmsBundle:partenaire:new.html.twig', array(
            'langue' => $langue,
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

        return $this->render('CmsBundle:presse:edit.html.twig', array(
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

<?php

namespace CmsBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Partenaire;
use CmsBundle\Form\PartenaireType;

/**
 * Partenaire controller.
 *
 */
class PartenaireController extends Controller
{
    /**
     * Lists all Partenaire entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findAll();

        return $this->render('CmsBundle:partenaire:index.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    /**
     * Creates a new Partenaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $langue = new Partenaire();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $artiste_fr = new Partenaire();
        $artiste_fr->setLangue('fr');
        $langue->getPartenaire()->add($artiste_fr);
        $artiste_en = new Partenaire();
        $artiste_en->setLangue('en');
        $langue->getPartenaire()->add($artiste_en);
        $artiste_es= new Partenaire();
        $artiste_es->setLangue('es');
        $langue->getPartenaire()->add($artiste_es);

        // end dummy code

        $form = $this->createFormBuilder($langue)
            ->add('partenaire', CollectionType::class, array(
                'entry_type' => PartenaireType::class
            ))
            ->add('submit','submit')
            ->getForm();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire_fr);
            $em->persist($partenaire_en);
            $em->persist($partenaire_es);
            $em->flush();

            return $this->redirectToRoute('artiste_new');
        }

        return $this->render('CmsBundle:Artiste:new.html.twig', array(
            'langue' => $langue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Partenaire entity.
     *
     */
    public function showAction(Partenaire $partenaire)
    {
        $deleteForm = $this->createDeleteForm($partenaire);

        return $this->render('CmsBundle:partenaire:show.html.twig', array(
            'partenaire' => $partenaire,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Partenaire entity.
     *
     */
    public function editAction(Request $request, Partenaire $partenaire)
    {
        $deleteForm = $this->createDeleteForm($partenaire);
        $editForm = $this->createForm('CmsBundle\Form\PartenaireType', $partenaire);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($editForm->get('file')->getData() != null) {

                if($partenaire->getImage() != null) {
                    unlink(__DIR__.'/../../../web/uploads/imgcms/'.$partenaire->getImage());
                    $partenaire->setImage(null);
                }
            }

            $partenaire->preUpload();

            $em->persist($partenaire);
            $em->flush();

            return $this->redirectToRoute('partenaire_edit', array('id' => $partenaire->getId()));
        }

        return $this->render('CmsBundle:partenaire:edit.html.twig', array(
            'partenaire' => $partenaire,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Partenaire entity.
     *
     */
    public function deleteAction(Request $request, Partenaire $partenaire)
    {
        $form = $this->createDeleteForm($partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($partenaire);
            $em->flush();
        }

        return $this->redirectToRoute('partenaire_index');
    }

    /**
     * Creates a form to delete a Partenaire entity.
     *
     * @param Partenaire $partenaire The Partenaire entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Partenaire $partenaire)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('partenaire_delete', array('id' => $partenaire->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

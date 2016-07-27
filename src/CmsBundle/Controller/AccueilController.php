<?php

namespace CmsBundle\Controller;

use CmsBundle\Form\LangueType;
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
        $langue = new Accueil();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $accueil_fr = new Accueil();
        $accueil_fr->setLangue('fr');
        $langue->getAccueil()->add($accueil_fr);
        $accueil_en = new Accueil();
        $accueil_en->setLangue('en');
        $langue->getAccueil()->add($accueil_en);
        $accueil_es = new Accueil();
        $accueil_es->setLangue('es');
        $langue->getAccueil()->add($accueil_es);

        // end dummy code

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil_fr);
            $em->persist($accueil_en);
            $em->persist($accueil_es);
            $em->flush();

            return $this->redirectToRoute('accueil_index');
        }

        return $this->render('CmsBundle:Accueil:new.html.twig', array(
            'langue' => $langue,
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

            if($editForm->get('file')->getData() != null) {

                if($accueil->getImage() != null) {
                    unlink(__DIR__.'/../../../web/uploads/imgcms/'.$accueil->getImage());
                    $accueil->setImage(null);
                }
            }

            $accueil->preUpload();

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

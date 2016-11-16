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
     * Creates a new Presse entity.
     *
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $presses = $em->getRepository('CmsBundle:Presse')->findAll();

        return $this->render('@Cms/presse/index.html.twig', array(
            'presses' => $presses
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

            return $this->redirectToRoute('presse_index');
        }

        return $this->render('@Cms/presse/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Presse entity.
     *
     */
    public function editAction(Request $request, Presse $presse)
    {
        $em = $this->getDoctrine()->getManager();

        $presse = $em->getRepository('CmsBundle:Presse')->findBy($presse);

        $editForm = $this->createForm('CmsBundle\Form\PresseType', $presse);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $presse->preUpload();

            $em->persist($presse);
            $em->flush();

            return $this->redirectToRoute('presse_index');
        }

        return $this->render('CmsBundle:presse:edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'presse' => $presse

        ));
    }
    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $presse = $em->getRepository('CmsBundle:Presse')->findOneById($id);

        if (!$presse) {
            throw $this->createNotFoundException(
                'Pas de presse trouvé'
            );
        }

        $em->remove($presse);
        $em->flush();

        return $this->redirectToRoute('presse_index');
    }
}

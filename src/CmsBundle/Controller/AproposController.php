<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Apropos;
use CmsBundle\Form\AproposType;

/**
 * Apropos controller.
 *
 */
class AproposController extends Controller
{
    /**
     * Creates a new Apropos entity.
     *
     */
    public function newAction(Request $request)
    {
        $apropo = new Apropos();
        $form = $this->createForm('CmsBundle\Form\AproposType', $apropo);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($apropo);
            $em->flush();

            return $this->redirectToRoute('user_apropos', array('id' => $apropo->getId()));
        }

        return $this->render('CmsBundle:apropos:new.html.twig', array(
            'apropo' => $apropo,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Apropos entity.
     *
     */
    public function editAction(Request $request, Apropos $apropo)
    {
        $editForm = $this->createForm('CmsBundle\Form\AproposType', $apropo);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($apropo);
            $em->flush();

            return $this->redirectToRoute('user_apropos');
        }

        return $this->render('@Cms/apropos/edit.html.twig', array(
            'apropo' => $apropo,
            'edit_form' => $editForm->createView(),
        ));
    }

}

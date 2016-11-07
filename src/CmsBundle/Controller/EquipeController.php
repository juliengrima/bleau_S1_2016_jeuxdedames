<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Equipe;
use CmsBundle\Entity\Images;
use CmsBundle\Form\EquipeType;

/**
 * Equipe controller.
 *
 */
class EquipeController extends Controller
{
    /**
     * Lists all Equipe entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $equipes = $em->getRepository('CmsBundle:Equipe')->findAll();

        return $this->render('CmsBundle:equipe:index.html.twig', array(
            'equipes' => $equipes,
        ));
    }

    /**
     * Creates a new Equipe entity.
     *
     */
    public function newAction(Request $request)
    {
        $equipe = new Equipe();
        $form = $this->createForm('CmsBundle\Form\EquipeType', $equipe);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipe);
            $em->flush();

            return $this->redirectToRoute('admin_equipe_index');
        }

        return $this->render('CmsBundle:equipe:new.html.twig', array(
            'equipe' => $equipe,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Equipe entity.
     *
     */
    public function editAction(Request $request, Equipe $equipe)
    {
        $editForm = $this->createForm('CmsBundle\Form\EquipeType', $equipe);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $equipe->getImages()->preUpload();
            $em = $this->getDoctrine()->getManager();
            $em->persist($equipe);
            $em->flush();

            return $this->redirectToRoute('user_apropos', array('id' => $equipe->getId()));
        }

        return $this->render('CmsBundle:equipe:edit.html.twig', array(
            'equipe' => $equipe,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Equipe entity.
     *
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $membre = $em->getRepository('CmsBundle:Equipe')->findOneById($id);
        $img_membre = $em->getRepository('CmsBundle:Images')->findOneById($membre->getImages()->getId());

        $em->remove($membre);
        $em->remove($img_membre);
        $em->flush();

        return $this->redirectToRoute('user_apropos');
    }
}

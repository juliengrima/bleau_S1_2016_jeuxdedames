<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CommercantController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();

        return $this->render('CmsBundle:Commercant:index.html.twig', array(
            'commercants' => $commercants,
            ));
    }

    public function newAction()
    {
        $commercants = new Commercant();
        $form = $this->createForm('CmsBundle\Form\CommercantType', $commercants);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($commercants);
            $em->flush();

            return $this->redirectToRoute('commercant_show', array('id' => $commercants->getId()));
        }

        return $this->render('CmsBundle:Commercant:new.html.twig', array(
            'commercant' => $commercants,
            'form' => $form->createView(),
        ));
    }

    public function showAction()
    {
        $deleteForm = $this->createDeleteForm($commercants);

        return $this->render('CmsBundle:Commercant:show.html.twig', array(
            'commercants' => $commercants,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    public function editAction()
    {
        return $this->render('CmsBundle:Commercant:edit.html.twig', array(
            // ...
        ));
    }

    public function deleteAction()
    {
        return $this->render('CmsBundle:Commercant:delete.html.twig', array(
            // ...
        ));
    }

}

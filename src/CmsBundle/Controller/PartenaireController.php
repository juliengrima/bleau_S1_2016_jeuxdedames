<?php

namespace CmsBundle\Controller;

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
     * List all Partenaire
     *
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findAll();
        return $this->render('@Cms/partenaire/index.html.twig', array(
            'partenaires' => $partenaires
        ));
    }


    /**
     * Creates a new Partenaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $partenaire = new Partenaire();
        $form = $this->createForm('CmsBundle\Form\PartenaireType', $partenaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($partenaire);
            $em->flush();

            return $this->redirectToRoute('user_partenaire');
        }

        return $this->render('CmsBundle:partenaire:new.html.twig', array(
            'partenaire' => $partenaire,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Partenaire entity.
     *
     */
    public function editAction(Request $request, Partenaire $partenaire)
    {
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

            return $this->redirectToRoute('user_partenaire', array('id' => $partenaire->getId()));
        }

        return $this->render('CmsBundle:partenaire:edit.html.twig', array(
            'partenaire' => $partenaire,
            'form' => $editForm->createView(),
        ));
    }


    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $partenaire = $em->getRepository('CmsBundle:Partenaire')->find($id);

        if (!$partenaire) {
            throw $this->createNotFoundException(
                'Pas de partenaire trouvé' . $id
            );
        }

        $em->remove($partenaire);
        $em->flush();

        return $this->redirectToRoute('user_partenaire');
    }
}
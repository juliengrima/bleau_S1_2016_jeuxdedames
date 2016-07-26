<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Artiste;
use CmsBundle\Form\ArtisteType;

/**
 * Artiste controller.
 *
 */
class ArtisteController extends Controller
{
    /**
     * Creates a new Artiste entity.
     *
     */
    public function newAction(Request $request)
    {
        $artiste = new Artiste();
        $form = $this->createForm('CmsBundle\Form\ArtisteType', $artiste);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $artiste->setDate(new \DateTime());
            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute('user_artiste', array('id' => $artiste->getId()));
        }

        return $this->render('@Cms/Artiste/new.html.twig', array(
            'artiste' => $artiste,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Artiste entity.
     *
     */
    public function editAction(Request $request, Artiste $artiste)
    {
        $editForm = $this->createForm('CmsBundle\Form\ArtisteType', $artiste);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            if($editForm->get('file')->getData() != null) {

                if($artiste->getImage() != null) {
                    unlink(__DIR__.'/../../../web/uploads/imgcms/'.$artiste->getImage());
                    $artiste->setImage(null);
                }
            }

            $artiste->preUpload();

            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute('user_artiste', array('id' => $artiste->getId()));
        }

        return $this->render('CmsBundle:Artiste:edit.html.twig', array(
            'artiste' => $artiste,
            'edit_form' => $editForm->createView(),
        ));
    }
    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $artiste = $em->getRepository('CmsBundle:Artiste')->find($id);
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        if (!$artiste) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($artiste);
        $em->flush();

        return $this->redirect($this->generateUrl('user_artiste', array(
            'artistes' => $artistes,
        )));
    }
}

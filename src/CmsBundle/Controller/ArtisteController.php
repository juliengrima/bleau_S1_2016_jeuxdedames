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
     * Index all artistes
     *
     */
    public function indexAction(){
        $em = $this->getDoctrine()->getManager();
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        return $this->render('@Cms/Artiste/index.html.twig', array(
            'artistes' => $artistes,
        ));
    }

    /**
     * Creates a new Artiste entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $categories = $em->getRepository('CmsBundle:Categorie')->findAll();

        $artiste = new Artiste();

        $form = $this->createForm(ArtisteType::class, $artiste);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $artiste->setDate(new \DateTime());

            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute('artiste_index');
        }

        return $this->render('@Cms/Artiste/new.html.twig', array(
            'form' => $form->createView(),
            'categorie' => $categories
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

            $artiste->preUpload();

            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute('artiste_index', array('id' => $artiste->getId()));
        }

        return $this->render('CmsBundle:Artiste:edit.html.twig', array(
            'edit_form' => $editForm->createView(),
            'artiste' => $artiste
        ));
    }

    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $artiste = $em->getRepository('CmsBundle:Artiste')->findOneById($id);

        if (!$artiste) {
            throw $this->createNotFoundException(
                'Pas d\'artiste trouvé'
            );
        }
        $em->remove($artiste);
        $em->flush();

        return $this->redirectToRoute('artiste_index');
    }
}

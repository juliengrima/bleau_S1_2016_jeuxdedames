<?php

namespace MobileBundle\Controller;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use CmsBundle\Entity\Artiste;
use MobileBundle\Form\ArtisteType;

/**
 * Artiste controller.
 *
 */
class ArtisteController extends Controller
{

    /**
     * Lists all mobileList entities.
     *
     */
    public function indexByArtistesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artiste = $em->getRepository('CmsBundle:Artiste')->findBy(array ('archive' => false));

        return $this->render('@Mobile/mobilelist/indexByArtistes.html.twig', array(
            'artistes' => $artiste,
        ));
    }

    /**
     * Displays a form to edit an existing Artiste entity.
     *
     */
    public function editAction(Request $request, Artiste $artiste)
    {
        $editForm = $this->createForm('MobileBundle\Form\ArtisteType', $artiste);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($artiste);
            $em->flush();

            return $this->redirectToRoute('mobilelist_indexByArtistes', array('id' => $artiste->getId()));
        }

        return $this->render('@Mobile/mobilelist/editByArtiste.html.twig', array(
            'edit_form' => $editForm->createView(),
            'artiste' => $artiste
        ));
    }
}

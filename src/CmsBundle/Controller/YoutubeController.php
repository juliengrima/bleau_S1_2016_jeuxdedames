<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\Youtube;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Youtube controller.
 *
 */
class YoutubeController extends Controller
{
    /**
     * Lists all youtube entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $youtubes = $em->getRepository('CmsBundle:Youtube')->findAll();

        return $this->render('@Cms/youtube/index.html.twig', array(
            'youtubes' => $youtubes,
        ));
    }

    /**
     * Creates a new youtube entity.
     *
     */
    public function newAction(Request $request)
    {
        $youtube = new Youtube();
        $form = $this->createForm('CmsBundle\Form\YoutubeType', $youtube);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($youtube);
            $em->flush($youtube);

            return $this->redirectToRoute('admin_youtube_index');
        }

        return $this->render('@Cms/youtube/new.html.twig', array(
            'youtube' => $youtube,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing youtube entity.
     *
     */
    public function editAction(Request $request, Youtube $youtube)
    {
        $editForm = $this->createForm('CmsBundle\Form\YoutubeType', $youtube);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_youtube_index');
        }

        return $this->render('@Cms/youtube/edit.html.twig', array(
            'youtube' => $youtube,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a youtube entity.
     *
     */
    public function deleteAction(Youtube $youtube){
        $em = $this->getDoctrine()->getManager();
        $video = $em->getRepository('CmsBundle:Youtube')->find($youtube);
        $em->remove($video);
        $em->flush();
        $this->redirectToRoute('admin_youtube_index');
    }
}

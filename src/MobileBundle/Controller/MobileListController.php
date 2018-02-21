<?php

namespace MobileBundle\Controller;

use MobileBundle\Entity\MobileList;
use CmsBundle\Entity\Artiste;
use MobileBundle\MobileBundle;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Mobilelist controller.
 *
 */
class MobileListController extends Controller
{

    /**
     * Lists all mobileList entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $mobileLists = $em->getRepository('MobileBundle:MobileList')->findAll();

        return $this->render('@Mobile/mobilelist/index.html.twig', array(
            'mobileLists' => $mobileLists,
        ));
    }

    /**
     * Creates a new mobileList entity.
     *
     */
    public function newAction(Request $request)
    {

        $mobileList = new Mobilelist();

        $form = $this->createForm('MobileBundle\Form\MobileListType', $mobileList);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($mobileList);
            $em->flush();

            return $this->redirectToRoute('mobilelist_show', array('id' => $mobileList->getId()));
        }

        return $this->render('@Mobile/mobilelist/new.html.twig', array(
            'mobileList' => $mobileList,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a mobileList entity.
     *
     */
    public function showAction(MobileList $mobileList)
    {
        $deleteForm = $this->createDeleteForm($mobileList);

        return $this->render('@Mobile/mobilelist/show.html.twig', array(
            'mobileList' => $mobileList,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing mobileList entity.
     *
     */
    public function editAction(Request $request, MobileList $mobileList)
    {
        $deleteForm = $this->createDeleteForm($mobileList);
        $editForm = $this->createForm('MobileBundle\Form\MobileListType', $mobileList);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('mobilelist_show', array('id' => $mobileList->getId()));
        }

        return $this->render('@Mobile/mobilelist/edit.html.twig', array(
            'mobileList' => $mobileList,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a mobileList entity.
     *
     */
    public function deleteAction(Request $request, MobileList $mobileList)
    {
        $form = $this->createDeleteForm($mobileList);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($mobileList);
            $em->flush();
        }

        return $this->redirectToRoute('mobilelist_index');
    }

    /**
     * Creates a form to delete a mobileList entity.
     *
     * @param MobileList $mobileList The mobileList entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(MobileList $mobileList)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('mobilelist_delete', array('id' => $mobileList->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}

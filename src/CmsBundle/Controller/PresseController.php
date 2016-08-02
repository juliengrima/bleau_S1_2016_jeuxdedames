<?php

namespace CmsBundle\Controller;


use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_item_max = $em->getRepository('CmsBundle:Presse')->getIdItemPresse();
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();


        $langue = new Presse();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $presse_fr = new Presse();
        $presse_fr->setLangue('fr');
        $langue->getPresse()->add($presse_fr);


        if ($langue_active == true){
            if (empty($accueil_en)) {
                $presse_en = new Presse();
                $presse_en->setLangue('en');
                $langue->getPresse()->add($presse_en);
            }
        }
        // end dummy code

        $form = $this->createFormBuilder($langue)
            ->add('presse', CollectionType::class, array(
                'entry_type' => PresseType::class
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $presse_fr->setItemId($id_item_max[0][1] + 1);

            if ($langue_active == true){
            $presse_en->setItemId($presse_fr->getItemId());
            $presse_en->setImage($presse_fr->getImage());
            $presse_en->setDate($presse_fr->getDate());
            $presse_en->setLien($presse_fr->getLien());
            }

            $em->persist($presse_fr);

            if ($langue_active == true) {
                $presse_en->setImage($presse_fr->getImage());
                $em->persist($presse_en);
            }

            $em->flush();

            return $this->redirectToRoute('user_presse');
        }

        return $this->render('@Cms/presse/new.html.twig', array(
            'form' => $form->createView(),
            'langue_active' => $langue_active
        ));
    }

    /**
     * Displays a form to edit an existing Presse entity.
     *
     */
    public function editAction(Request $request, Presse $presse)
    {
        $em = $this->getDoctrine()->getManager();

        $id_item = $presse->getItemId();

        $presse_fr = $em->getRepository('CmsBundle:Presse')->findOneBy(array('langue' => 'fr', 'item_id' => $id_item));
        $presse_en = $em->getRepository('CmsBundle:Presse')->findOneBy(array('langue' => 'en', 'item_id' => $id_item));
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $langue = new Presse();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $langue->getPresse()->add($presse_fr);

        if ($langue_active == true){
            if (empty($presse_en) == false){
                $presse_en = new Presse();
                $presse_en->setLangue('en');
                $presse_en->setItemId($presse_en->getItemId());
            }
            $langue->getPresse()->add($presse_en);
        }

        $editForm = $this->createFormBuilder($langue)
            ->add('presse', CollectionType::class, array(
                'entry_type' => PresseType::class
            ))
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $presse_fr->preUpload();

            $em->persist($presse_fr);
            $em->flush();

            if ($langue_active == true){
                $presse_en->setDate($presse_fr->getDate());
                $presse_en->setImage($presse_fr->getImage());
                $em->persist($presse_en);
                $em->flush();
            }

            return $this->redirectToRoute('user_presse', array('id' => $presse->getId()));
        }

        return $this->render('CmsBundle:presse:edit.html.twig', array(
            'form' => $editForm->createView(),
            'langue_active' => $langue_active
        ));
    }
    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $presse_id_item = $em->getRepository('CmsBundle:Presse')->find($id)->getItemId();

        $presse_fr = $em->getRepository('CmsBundle:Presse')->findOneBy(array('langue' => 'fr', 'item_id' => $presse_id_item));
        $presse_en = $em->getRepository('CmsBundle:Presse')->findOneBy(array('langue' => 'en', 'item_id' => $presse_id_item));

        $presses = $em->getRepository('CmsBundle:Presse')->findAll();

        if (!$presse_id_item) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($presse_fr);

        if ($presse_en != null)
            $em->remove($presse_en);

        $em->flush();

        return $this->redirect($this->generateUrl('user_presse', array(
            'presses' => $presses,
        )));
    }
}

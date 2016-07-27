<?php

namespace CmsBundle\Controller;

use CmsBundle\Form\AccueilType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
        $em = $this->getDoctrine()->getManager();
        $id_item_max = $em->getRepository('CmsBundle:Artiste')->getIdItemArtiste();

        $langue = new Artiste();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $artiste_fr = new Artiste();
        $artiste_fr->setLangue('fr');
        $langue->getArtiste()->add($artiste_fr);
        $artiste_en = new Artiste();
        $artiste_en->setLangue('en');
        $langue->getArtiste()->add($artiste_en);
        $artiste_es= new Artiste();
        $artiste_es->setLangue('es');
        $langue->getArtiste()->add($artiste_es);

        // end dummy code

        $form = $this->createFormBuilder($langue)
            ->add('artiste', CollectionType::class, array(
                'entry_type' => ArtisteType::class
                    ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $artiste_fr->setDate(new \DateTime());
            $artiste_fr->setItemId($id_item_max[0][1] + 1);
            $artiste_en->setDate($artiste_fr->getDate());
            $artiste_es->setDate($artiste_fr->getDate());
            $artiste_en->setAjouterslider(0);
            $artiste_es->setAjouterslider(0);
            $artiste_en->setArchive(0);
            $artiste_es->setArchive(0);
            $artiste_en->setItemId($artiste_fr->getItemId());
            $artiste_es->setItemId($artiste_fr->getItemId());

            $em->persist($artiste_fr);

            $artiste_en->setImage($artiste_fr->getImage());
            $artiste_es->setImage($artiste_fr->getImage());

            $em->persist($artiste_en);
            $em->persist($artiste_es);
            $em->flush();

            return $this->redirectToRoute('user_artiste');
        }

        return $this->render('@Cms/Artiste/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Artiste entity.
     *
     */
    public function editAction(Request $request, Artiste $artiste)
    {
        $em = $this->getDoctrine()->getManager();

        $id_item = $artiste->getItemId();

        $artiste_fr = $em->getRepository('CmsBundle:Artiste')->findOneBy(array('langue' => 'fr', 'item_id' => $id_item));
        $artiste_en = $em->getRepository('CmsBundle:Artiste')->findOneBy(array('langue' => 'en', 'item_id' => $id_item));
        $artiste_es = $em->getRepository('CmsBundle:Artiste')->findOneBy(array('langue' => 'es', 'item_id' => $id_item));

        $langue = new Artiste();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $langue->getArtiste()->add($artiste_fr);
        $langue->getArtiste()->add($artiste_en);
        $langue->getArtiste()->add($artiste_es);

        $editForm = $this->createFormBuilder($langue)
            ->add('artiste', CollectionType::class, array(
                'entry_type' => ArtisteType::class
            ))
            ->getForm();

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

            $em->persist($langue);
            $em->flush();

            return $this->redirectToRoute('user_artiste', array('id' => $artiste->getId()));
        }

        return $this->render('CmsBundle:Artiste:edit.html.twig', array(
            'form' => $editForm->createView(),
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

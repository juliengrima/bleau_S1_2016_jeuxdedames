<?php

namespace CmsBundle\Controller;


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
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $langue = new Artiste();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $artiste_fr = new Artiste();
        $artiste_fr->setLangue('fr');
        $langue->getArtiste()->add($artiste_fr);

        if ($langue_active == true){
            if (empty($accueil_en)) {
                $artiste_en = new Artiste();
                $artiste_en->setLangue('en');
                $langue->getArtiste()->add($artiste_en);
            }
        }

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

            if ($langue_active == true){
                $artiste_en->setDate($artiste_fr->getDate());
                $artiste_en->setCategorie($artiste_fr->getCategorie());
                $artiste_en->setAjouterslider($artiste_fr->getAjouterslider());
                $artiste_en->setArchive($artiste_fr->getArchive());
                $artiste_en->setItemId($artiste_fr->getItemId());
            }


            $em->persist($artiste_fr);

            if ($langue_active == true) {
                $artiste_en->setImage($artiste_fr->getImage());
                $em->persist($artiste_en);
            }

            $em->flush();

            return $this->redirectToRoute('user_artiste');
        }

        return $this->render('@Cms/Artiste/new.html.twig', array(
            'form' => $form->createView(),
            'langue_active' => $langue_active
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
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $langue = new Artiste();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $langue->getArtiste()->add($artiste_fr);

        if ($langue_active == true){
            if (empty($accueil_en) == false){
                $artiste_en = new Artiste();
                $artiste_en->setLangue('en');
                $artiste_en->setItemId($artiste_fr->getItemId());
            }
            $langue->getArtiste()->add($artiste_en);
        }

        $editForm = $this->createFormBuilder($langue)
            ->add('artiste', CollectionType::class, array(
                'entry_type' => ArtisteType::class
            ))
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $artiste_fr->preUpload();

            $em->persist($artiste_fr);
            $em->flush();

            if ($langue_active == true){
                $artiste_en->setDate($artiste_fr->getDate());
                $artiste_en->setImage($artiste_fr->getImage());
                $artiste_en->setAjouterslider($artiste_fr->getAjouterslider());
                $artiste_en->setArchive($artiste_fr->getArchive());
                $em->persist($artiste_en);
                $em->flush();
            }

            return $this->redirectToRoute('user_artiste', array('id' => $artiste->getId()));
        }

        return $this->render('CmsBundle:Artiste:edit.html.twig', array(
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
        $artiste_id_item = $em->getRepository('CmsBundle:Artiste')->find($id)->getItemId();

        $artiste_fr = $em->getRepository('CmsBundle:Artiste')->findOneBy(array('langue' => 'fr', 'item_id' => $artiste_id_item));
        $artiste_en = $em->getRepository('CmsBundle:Artiste')->findOneBy(array('langue' => 'en', 'item_id' => $artiste_id_item));

        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        if (!$artiste_id_item) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($artiste_fr);

        if ($artiste_en != null)
            $em->remove($artiste_en);

        $em->flush();

        return $this->redirect($this->generateUrl('user_artiste', array(
            'artistes' => $artistes,
        )));
    }
}

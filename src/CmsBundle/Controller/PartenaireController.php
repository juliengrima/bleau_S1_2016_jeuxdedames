<?php

namespace CmsBundle\Controller;

use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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
     * Lists all Partenaire entities.
     *
     */

    /**
     * Creates a new Partenaire entity.
     *
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id_item_max = $em->getRepository('CmsBundle:Artiste')->getIdItemArtiste();

        $langue = new Partenaire();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $partenaire_fr = new Partenaire();
        $partenaire_fr->setLangue('fr');
        $langue->getPartenaire()->add($partenaire_fr);
        $partenaire_en = new Partenaire();
        $partenaire_en->setLangue('en');
        $langue->getPartenaire()->add($partenaire_en);
        $partenaire_es= new Partenaire();
        $partenaire_es->setLangue('es');
        $langue->getPartenaire()->add($partenaire_es);

        // end dummy code

        $form = $this->createFormBuilder($langue)
            ->add('partenaire', CollectionType::class, array(
                'entry_type' => PartenaireType::class
            ))
            ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $partenaire_fr->setItemId($id_item_max[0][1] + 1);
            $em->persist($partenaire_fr);
            $em->persist($partenaire_en);
            $em->persist($partenaire_es);
            $partenaire_en->setItemId($artiste_fr->getItemId());
            $partenaire_es->setItemId($artiste_fr->getItemId());

            $em->persist($artiste_fr);

            $partenaire_en->setImage($artiste_fr->getImage());
            $partenaire_es->setImage($artiste_fr->getImage());

            $em->persist($partenaire_en);
            $em->persist($partenaire_es);
            $em->flush();

            return $this->redirectToRoute('user_partenaire');
        }

        return $this->render('@Cms/partenaire/new.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    

    /**
     * Displays a form to edit an existing Partenaire entity.
     *
     */
    public function editAction(Request $request, Partenaire $partenaire)
    {
        $em = $this->getDoctrine()->getManager();

        $id_item = $partenaire->getItemId();

        $partenaire_fr = $em->getRepository('CmsBundle:Partenaire')->findOneBy(array('langue' => 'fr', 'item_id' => $id_item));
        $partenaire_en = $em->getRepository('CmsBundle:Partenaire')->findOneBy(array('langue' => 'en', 'item_id' => $id_item));
        $partenaire_es = $em->getRepository('CmsBundle:Partenaire')->findOneBy(array('langue' => 'es', 'item_id' => $id_item));

        $langue = new Partenaire();

        // dummy code - this is here just so that the Task has some tags
        // otherwise, this isn't an interesting example
        $langue->getPartenaire()->add($partenaire_fr);
        $langue->getPartenaire()->add($partenaire_en);
        $langue->getPartenaire()->add($partenaire_es);

        $editForm = $this->createFormBuilder($langue)
            ->add('partenaire', CollectionType::class, array(
                'entry_type' => PartenaireType::class
            ))
            ->getForm();

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

            $em->persist($langue);
            $em->flush();

            return $this->redirectToRoute('user_partenaire', array('id' => $partenaire->getId()));
        }

        return $this->render('CmsBundle:partenaire:edit.html.twig', array(
            'partenaire' => $partenaire,
            'edit_form' => $editForm->createView(),
            'form' => $editForm->createView(),
        ));
    }

    /**
     * Deletes a Partenaire entity.
     *
     */
    public function deleteAction($id) {

        $em = $this->getDoctrine()->getManager();
        $partenaire = $em->getRepository('CmsBundle:Partenaire')->find($id);
        $partenaire = $em->getRepository('CmsBundle:Partenaire')->findAll();

        if (!$partenaire) {
            throw $this->createNotFoundException(
                'Pas de document trouvé' . $id
            );
        }

        $em->remove($partenaire);
        $em->flush();

        return $this->redirect($this->generateUrl('user_partenaire', array(
            'partenaires' => $partenaire,
        )));
    }
}

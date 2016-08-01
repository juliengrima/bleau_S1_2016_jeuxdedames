<?php

namespace CmsBundle\Controller;

use CmsBundle\Form\LangueType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Accueil;
use CmsBundle\Form\AccueilType;


/**
 * Accueil controller.
 *
 */
class AccueilController extends Controller
{
    /**
     * Creates a new Accueil entity.
     *
     */
    public function newAction(Request $request)
    {
        $langue = new Accueil();

        $accueil_fr = new Accueil();
        $accueil_fr->setLangue('fr');
        $langue->getAccueil()->add($accueil_fr);
        $accueil_en = new Accueil();
        $accueil_en->setLangue('en');
        $langue->getAccueil()->add($accueil_en);

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($accueil_fr);

            $accueil_en->setImage($accueil_fr->getImage());

            $em->persist($accueil_en);
            $em->flush();

            return $this->redirectToRoute('cms_homepage');
        }

        return $this->render('CmsBundle:Accueil:new.html.twig', array(
            'langue' => $langue,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Accueil entity.
     *
     */
    public function editAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $accueil_fr = $em->getRepository('CmsBundle:Accueil')->findOneBy(array('langue' => 'fr'));
        $accueil_en = $em->getRepository('CmsBundle:Accueil')->findOneBy(array('langue' => 'en'));

        $langue = new Accueil();

        $langue->getAccueil()->add($accueil_fr);
        $langue->getAccueil()->add($accueil_en);

        $editForm = $this->createFormBuilder($langue)
            ->add('accueil', CollectionType::class, array(
                'entry_type' => AccueilType::class
            ))
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $accueil_fr->preUpload();

            $em->persist($accueil_fr);
            $em->flush();

            $accueil_en->setImage($accueil_fr->getImage());
            $em->persist($accueil_en);
            $em->flush();

            return $this->redirectToRoute('cms_homepage');
        }

        return $this->render('CmsBundle:Accueil:edit.html.twig', array(
            'accueil' => $langue,
            'form' => $editForm->createView(),
        ));
    }
}

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
        $em = $this->getDoctrine()->getManager();

        $langue_active = false;

        if (!empty($em->getRepository('CmsBundle:Accueil')->findAll())){
            $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();
        }

        $langue = new Accueil();

        $accueil_fr = new Accueil();
        $accueil_fr->setLangue('fr');
        $langue->getAccueil()->add($accueil_fr);

        if ($langue_active == true) {
            $accueil_en = new Accueil();
            $accueil_en->setLangue('en');
            $langue->getAccueil()->add($accueil_en);
        }

        $form = $this->createForm(LangueType::class, $langue);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($langue_active == true) {
                $em->persist($accueil_fr);
                $accueil_en->setImage($accueil_fr->getImage());
                $em->persist($accueil_en);
            }
            $em->persist($accueil_fr);
            $em->flush();

            return $this->redirectToRoute('cms_homepage');
        }

        return $this->render('CmsBundle:Accueil:new.html.twig', array(
            'langue' => $langue,
            'form' => $form->createView(),
            'langue_active' => $langue_active
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

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $langue = new Accueil();
        $langue->getAccueil()->add($accueil_fr);

        if ($langue_active == true){
            if (empty($accueil_en)){
                $accueil_en = new Accueil();
                $accueil_en->setLangue('en');
                $langue->getAccueil()->add($accueil_en);
            }
        }

        $editForm = $this->createFormBuilder($langue)
            ->add('accueil', CollectionType::class, array(
                'entry_type' => AccueilType::class
            ))
            ->getForm();

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $accueil_fr->preUpload();

            if ($langue_active == true) {
                $em->persist($accueil_fr);
                $em->flush();
                $accueil_en->setImage($accueil_fr->getImage());
                $em->persist($accueil_en);
            }
            else{
                $em->persist($accueil_fr);
            }
            $em->flush();

            return $this->redirectToRoute('cms_homepage');
        }

        return $this->render('CmsBundle:Accueil:edit.html.twig', array(
            'accueil' => $langue,
            'form' => $editForm->createView(),
            'langue_active' => $langue_active
        ));
    }
}

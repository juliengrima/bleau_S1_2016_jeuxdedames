<?php

namespace CmsBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    private function UserGetLocal(){
        $request = $this->get('request');
        return $request->getLocale();
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        if (empty($em->getRepository('CmsBundle:Accueil')->findAll())){
            return $this->redirectToRoute('accueil_new');
        }

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        if ($langue_active == false)
            $accueils = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'));
        else
            $accueils = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => $local));

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local));

        return $this->render('CmsBundle:User:index.html.twig', array(
            'accueils' => $accueils,
            'artistes' => $artistes,
            'langue_active' => $langue_active
        ));
    }    

    public function artistesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();
        $status = 0;
        $categorie_name = null;

//      Creation du formulaire pour recherche artiste
        $formBuilder = $this->get('form.factory')->createBuilder('form');
        $formBuilder
            ->add('categoris', EntityType::class, array(
                'class' => 'CmsBundle\Entity\Categorie',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.nomDeLaCategorie', 'ASC');
                },
                'choice_label' => 'nomDeLaCategorie',
                'placeholder' => 'Spécifiez une catégorie',
                'empty_data'  => null,
                'required' => false
            ));
        $form = $formBuilder->getForm();
        $form->handleRequest($request);

        if ($form->getViewData() != null && $form->getViewData()['categoris'] != null)
        {
            $categorie = $form->getViewData()['categoris'];
            $categorie_name = $categorie->getNomDeLaCategorie();
            $categorie_id = $categorie->getId();
            $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(
                array(
                    'langue' => $local,
                    'archive' => 0,
                    'categorie' => $categorie_id
                ),
                array('nom' => 'asc'));
            $status = 1;
        }
        else
        {
            $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local,'archive' => 0), array('nom' => 'asc'));

        }

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'form' => $form->createView(),
            'artistes' => $artistes,
            'langue_active' => $langue_active,
            'categorie_name' => $categorie_name,
            'status' => $status
        ));
    }

    public function commercantsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        return $this->render('CmsBundle:User:commercants.html.twig', array(
            'commercants' => $commercants,
            'langue_active' => $langue_active
        ));
    }

    public function partenairesAction()
    {

        $em = $this->getDoctrine()->getManager();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findBy(array(), array('donation' => 'desc'));

        return $this->render('CmsBundle:User:partenaires.html.twig', array(
            'partenaires' => $partenaires,
            'langue_active' => $langue_active
        ));
    }
    public function archivesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local,'archive' => 1));

        $years = null;
        foreach ($artistes as $artiste) {
            $years[] = $artiste->getDate()->format("Y");
        }

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'years' => $years,
            'artistes' => $artistes,
            'langue_active' => $langue_active
        ));
    }

    public function pressesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $presses = $em->getRepository('CmsBundle:Presse')->findBy(array('langue' => $local));

        return $this->render('CmsBundle:User:presses.html.twig' , array (
            'presses' => $presses,
            'langue_active' => $langue_active
        ));
    }

    public function aproposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $apropos = $em->getRepository('CmsBundle:Apropos')->findAll();
        $equipe = $em->getRepository('CmsBundle:Equipe')->findBy(array(), array('nom' => 'asc'));

        return $this->render('CmsBundle:User:apropos.html.twig' , array (
            'apropos' => $apropos,
            'equipe' => $equipe
        ));
    }
}
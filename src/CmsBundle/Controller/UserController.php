<?php

namespace CmsBundle\Controller;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('CmsBundle:Accueil')->getAccueilContent();
        $artistes = $em->getRepository('CmsBundle:Artiste')->getImageSlider();
        return $this->render('CmsBundle:User:index.html.twig', array(
            'accueil' => $accueils,
            'artistes' => $artistes,
        ));

    }    

    public function artistesAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

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
                    'archive' => 0,
                    'categorie' => $categorie_id
                ),
                array('nom' => 'asc'));
            $status = 1;
        }
        else
        {
            $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('archive' => 0), array('nom' => 'asc'));

        }

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'form' => $form->createView(),
            'artistes' => $artistes,
            'categorie_name' => $categorie_name,
            'status' => $status
        ));
    }

    public function commercantsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();

        $wrong_commercant = array();
        foreach ($commercants as $key => $commercant){
            if (!$commercant->getLat() || !$commercant->getLng()){
                $securityContext = $this->container->get('security.authorization_checker');
                if ($securityContext->isGranted('ROLE_SUPER_ADMIN')) {
                    $wrong_commercant[] = $commercants[$key];
                }
                unset($commercants[$key]);
            }
        }

        return $this->render('CmsBundle:User:commercants.html.twig', array(
            'wrong_commercant' => $wrong_commercant,
            'commercants' => $commercants,
        ));
    }

    public function partenairesAction()
    {

        $em = $this->getDoctrine()->getManager();
        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findBy(array(), array('donation' => 'desc'));

        return $this->render('CmsBundle:User:partenaires.html.twig', array(
            'partenaires' => $partenaires,
        ));
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function archivesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('archive' => 1));
        $videos = $em->getRepository('CmsBundle:Youtube')->findBy(array(), array('title' => 'ASC'));

        $categ_id = array();
        foreach ($artistes as  $artiste){
            if (!is_null($artiste->getCategorie())){
                if (!in_array($artiste->getCategorie()->getId(), $categ_id)){
                    $categ_id[] = $artiste->getCategorie()->getId();
                }
            }
        }

        $categories = $em->getRepository('CmsBundle:Categorie')->findBy(array('id' => $categ_id));

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'artistes' => $artistes,
            'categories' => $categories,
            'videos' => $videos
        ));
    }

    public function pressesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $presses = $em->getRepository('CmsBundle:Presse')->findAll();

        return $this->render('CmsBundle:User:presses.html.twig' , array (
            'presses' => $presses,
        ));
    }

    public function aproposAction()
    {
        $em = $this->getDoctrine()->getManager();

        $apropos = $em->getRepository('CmsBundle:Apropos')->findOneBy(array());
        $equipe = $em->getRepository('CmsBundle:Equipe')->findBy(array(), array('nom' => 'asc'));

        return $this->render('CmsBundle:User:apropos.html.twig' , array (
            'apropos' => $apropos,
            'equipe' => $equipe
        ));
    }
}
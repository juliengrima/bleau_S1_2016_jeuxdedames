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
            $artistes = $em->getRepository('CmsBundle:Artiste')->getAllArtisteArchiveFalse($categorie);
            $status = 1;
        }
        else
        {
            $artistes = $em->getRepository('CmsBundle:Artiste')->getAllArtisteArchiveFalse($categorie = null);
        }

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'form' => $form->createView(),
            'artistes' => $artistes,
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

        $categories = $em->getRepository('CmsBundle:Categorie')->getAllArtisteArchiveTrue();

        $sortCategories = array();
        foreach($categories as $key => $item)
        {
            $sortCategories[$item['nomDeLaCategorie']][$key] = $item;
        }

        $videos = $em->getRepository('CmsBundle:Youtube')->findBy(array(), array('title' => 'ASC'));

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'categories' => $sortCategories,
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
        $equipe = $em->getRepository('CmsBundle:Equipe')->getAllEquipeMembers();

        return $this->render('CmsBundle:User:apropos.html.twig' , array (
            'apropos' => $apropos,
            'equipe' => $equipe
        ));
    }
}
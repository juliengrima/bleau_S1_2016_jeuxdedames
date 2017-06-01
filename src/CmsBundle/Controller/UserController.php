<?php

namespace CmsBundle\Controller;

use CmsBundle\Form\SearchArtisteType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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
        $form = $this->createForm(SearchArtisteType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {
            $categorie = $form->getViewData()['categorie'];
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


        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'categories' => $sortCategories
        ));
    }

//    public function pressesAction()
//    {
//        $em = $this->getDoctrine()->getManager();
//
//        $presses = $em->getRepository('CmsBundle:Presse')->findAll();
//        $videos = $em->getRepository('CmsBundle:Youtube')->findBy(array(), array('title' => 'ASC'));
//
//        return $this->render('CmsBundle:User:presses.html.twig' , array (
//            'presses' => $presses,
//            'videos' => $videos
//        ));
//    }

    public function pressesAction(Request $request){
        if ($request->isXmlHttpRequest()){
            $select = $request->get('type');
            $em = $this->getDoctrine()->getManager();
            $response = new JsonResponse();
            $content = array(
                'content' => null
            );

            if ($select == null || $select == 'presseContent'){
                $presses = $em->getRepository('CmsBundle:Presse')->findAll();
                $content['content'] = $this->renderView('@Cms/User/include_presse/articles.html.twig', array(
                    'presses' => $presses
                ));
            }
            elseif ($select == 'videoContent'){
                $videos = $em->getRepository('CmsBundle:Youtube')->findBy(array(), array('title' => 'ASC'));
                $content['content'] = $this->renderView('@Cms/User/include_presse/videos.html.twig', array(
                    'videos' => $videos
                ));
            }

            $response->setData($content);
            return $response;
        }
        return $this->render('@Cms/User/presses.html.twig');
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
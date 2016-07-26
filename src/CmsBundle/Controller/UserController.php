<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('CmsBundle:Accueil')->findAll();
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        return $this->render('CmsBundle:User:index.html.twig', array(
            'accueils' => $accueils,
            'artistes' => $artistes,
        ));
    }    

    public function artistesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('archive' => 0));

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'artistes' => $artistes,
        ));
    }

    public function commercantsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();
        
        return $this->render('CmsBundle:User:commercants.html.twig', array(
            'commercants' => $commercants,
        ));
    }

    public function partenairesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findby(array(),array ('donation' => 'desc'));

        return $this->render('CmsBundle:User:partenaires.html.twig' , array (
            'partenaires' => $partenaires,
        ));
    }
    public function archivesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('archive' => 1));

        foreach ($artistes as $artiste) {
            $years[] = $artiste->getDate()->format("Y");
        }

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'years' => $years,
            'artistes' => $artistes,
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
}
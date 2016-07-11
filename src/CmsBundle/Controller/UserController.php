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

        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'artistes' => $artistes,
        ));
    }

    public function commercantsAction()
    {
        $commerçant = array(
            array(
                'adresse' => "37 rue saint honoré",
                'code' => 77300,
                'ville' => 'Fontainebleau'
            ),
            array(
                'adresse' => 'Place de la bastille',
                'code' => '',
                'ville' => 'Paris'
            )
        );
        
        return $this->render('CmsBundle:User:commercants.html.twig', array(
            'commercants' => $commerçant,
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
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();

        $archives = $em->getRepository('CmsBundle:Archive')->findAll();

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'archives' => $archives,
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
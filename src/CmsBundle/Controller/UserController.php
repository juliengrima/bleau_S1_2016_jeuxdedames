<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function indexAction()
    {
        return $this->render('CmsBundle:User:index.html.twig');
    }    

    public function artistesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findby(array(),array ('donation' => 'desc'));

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'artistes' => $artistes,
        ));
    }

    public function commercantsAction()
    {
        return $this->render('CmsBundle:User:commercants.html.twig');
    }

    public function partenairesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $partenaires = $em->getRepository('CmsBundle:Partenaire')->findAll();

        return $this->render('CmsBundle:User:partenaires.html.twig' , array (
            'partenaires' => $partenaires,
        ));
    }
}
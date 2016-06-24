<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $accueils = $em->getRepository('CmsBundle:Accueil')->findAll();
        $artistes = $em->getRepository('CmsBundle:Artiste')->findAll();
        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();


        return $this->render('CmsBundle:Admin:index.html.twig', array(
            'accueils' => $accueils,
            'artistes' => $artistes,
            'commercants' => $commercants,

        ));
    }
}

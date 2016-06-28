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
        return $this->render('CmsBundle:User:artistes.html.twig');
    }

    public function commercantsAction()
    {
        return $this->render('CmsBundle:User:commercants.html.twig');
    }

    public function partenairesAction()
    {
        return $this->render('CmsBundle:User:partenaires.html.twig');
    }
}
<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArchiveController extends Controller
{
    public function indexAction()
    {
        return $this->render('CmsBundle:User:archives.html.twig');
    }
}

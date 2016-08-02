<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        return $this->render('CmsBundle:User:index.html.twig', array(
            'langue_active' => $langue_active
        ));
    }
}

<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    private function UserGetLocal(){
        $request = $this->get('request');
        return $request->getLocale();
    }

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $accueils = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => $local));
        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local));

        return $this->render('CmsBundle:User:index.html.twig', array(
            'accueils' => $accueils,
            'artistes' => $artistes,
            'langue_active' => $langue_active
        ));
    }    

    public function artistesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local,'archive' => 0));

        return $this->render('CmsBundle:User:artistes.html.twig', array(
            'artistes' => $artistes,
            'langue_active' => $langue_active
        ));
    }

    public function commercantsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        return $this->render('CmsBundle:User:commercants.html.twig', array(
            'commercants' => $commercants,
            'langue_active' => $langue_active
        ));
    }

    public function partenairesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $partenaires = $em->getRepository('CmsBundle:Partenaire')
            ->findBy(
                array('langue' => $local),
                array('donation' => 'desc')
            );

        return $this->render('CmsBundle:User:partenaires.html.twig' , array (
            'partenaires' => $partenaires,
            'langue_active' => $langue_active
        ));
    }
    public function archivesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $artistes = $em->getRepository('CmsBundle:Artiste')->findBy(array('langue' => $local,'archive' => 1));

        foreach ($artistes as $artiste) {
            $years[] = $artiste->getDate()->format("Y");
        }

        return $this->render('CmsBundle:User:archives.html.twig' , array (
            'years' => $years,
            'artistes' => $artistes,
            'langue_active' => $langue_active
        ));
    }
    public function pressesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $local = $this->UserGetLocal();

        $langue_active = $em->getRepository('CmsBundle:Accueil')->findBy(array('langue' => 'fr'))[0]->getLangueActive();

        $presses = $em->getRepository('CmsBundle:Presse')->findBy(array('langue' => $local));

        return $this->render('CmsBundle:User:presses.html.twig' , array (
            'presses' => $presses,
            'langue_active' => $langue_active
        ));
    }
}
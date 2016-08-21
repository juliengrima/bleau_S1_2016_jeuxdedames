<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\AbonnementNews;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewslettersController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $list_users = $em->getRepository('CmsBundle:AbonnementNews')->findAll();

        return $this->render('CmsBundle:Newsletters:index.html.twig', array(
           'list_users' => $list_users
        ));
    }

    public function AbonnementAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $email = $request->request->get('email');
        $route = $request->request->get('route');

        $users_existants = $em->getRepository('CmsBundle:AbonnementNews')->findOneByEmail($email);

        if ($users_existants == null){
            $user = new AbonnementNews();
            $user->setEmail($email);
            $user->setEtat(true);
            $user->setDateInscription(new \DateTime());

            $em->persist($user);
            $em->flush();

            if ($request->getLocale() == 'fr')
                $request->getSession()->getFlashBag()->add('success',  'Vous etes bien enregistré à la Newsletter. Merci');
            else
                $request->getSession()->getFlashBag()->add('success',  'You are well recorded in the newsletter. Thanks');

            $url = $this->generateUrl($route);
            return $this->redirect($url);
        }
        else if ($users_existants->getEtat() == true) {
            if ($request->getLocale() == 'fr')
                $request->getSession()->getFlashBag()->add('error',  'Vous etes déja enregistré à la Newsletter. Merci');
            else
                $request->getSession()->getFlashBag()->add('error',  'You are already registered for the newsletter. Thanks');

            $url = $this->generateUrl($route);
            return $this->redirect($url);
        }
        elseif ($users_existants != null && $users_existants->getEtat() == false){
            $users_existants->setEtat(true);
            $em->persist($users_existants);
            $em->flush();

            if ($request->getLocale() == 'fr')
                $request->getSession()->getFlashBag()->add('success_reactivate',  'Vous venez de réactiver votre abonnement à la newsletter. Merci');
            else
                $request->getSession()->getFlashBag()->add('success_reactivate',  'You just activate your subscription to the newsletter. Thanks');

            $url = $this->generateUrl($route);
            return $this->redirect($url);
        }
    }

    public function DesabonnementAction(Request $request){

        $em = $this->getDoctrine()->getManager();

        $mail = $request->request->get('email');

        if ($mail != null){
            $user = $em->getRepository('CmsBundle:AbonnementNews')->findOneByEmail($mail);

            $user->setEtat(false);

            $em->persist($user);
            $em->flush();

            if ($request->getLocale() == 'fr')
                $request->getSession()->getFlashBag()->add('success',  'Vous venez de désactiver votre abonnement à la newsletter. Merci');
            else
                $request->getSession()->getFlashBag()->add('success',  'You just desactivate your subscription to the newsletter. Thanks');

            $url = $this->generateUrl('cms_homepage');

            return $this->redirect($url);
        }
        else{
            return $this->render('@Cms/User/desabonnement_newsletter.html.twig');
        }

    }
}

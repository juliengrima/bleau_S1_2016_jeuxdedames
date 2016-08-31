<?php

namespace CmsBundle\Controller;

use CmsBundle\Entity\Newsletter;
use CmsBundle\Form\NewsletterType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class NewsletterController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $newsletters = $em->getRepository('CmsBundle:Newsletter')->findBy(array(), array('dateCrea' => 'desc'));

        return $this->render('CmsBundle:Newsletter:show_newsletters.html.twig', array(
            'newsletters' => $newsletters,
        ));
    }

    public function newsletterCreateAction(Request $request){

        $newsletter = new Newsletter();

        $form = $this->createForm(NewsletterType::class, $newsletter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em = $this->getDoctrine()->getManager();

            $newsletter->setDateCrea(new \DateTime());
            $newsletter->setEtat(false);
            $newsletter->setPj(false);

            $em->persist($newsletter);
            $em->flush();

            $newsletter->preUpload();
            $newsletter->upload();

            $em->persist($newsletter);
            $em->flush();

            return $this->redirectToRoute('newsletters_show');
        }

        return $this->render('@Cms/Newsletter/create_newsletter.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function showAction($id){
        $em = $this->getDoctrine()->getManager();

        $newsletter = $em->getRepository('CmsBundle:Newsletter')->findOneById($id);

        return $this->render('CmsBundle:Newsletter:show_newsletter.html.twig', array(
            'newsletter' => $newsletter
        ));
    }

    public function editAction(Request $request, Newsletter $newsletter){
        $editForm = $this->createForm(NewsletterType::class, $newsletter);

        if ($newsletter->getFilename() != null)
            $editForm->add('pj');
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()){

            $em = $this->getDoctrine()->getManager();

            if ($newsletter->getFilename() != null && $newsletter->file != null || $newsletter->getPj() == true){
                $newsletter->removeUpload();
            }

            $newsletter->setPj(false);
            $em->persist($newsletter);
            $em->flush();

            $newsletter->preUpload();
            $newsletter->upload();

            $em->persist($newsletter);
            $em->flush();

            $request->getSession()
                ->getFlashBag()
                ->add('succes_edit',  'La newsletter a bien été édité')
            ;

            return $this->redirectToRoute('newsletters_show');
        }

        return $this->render('CmsBundle:Newsletter:edit_newsletter.html.twig', array(
            'edit_form' => $editForm->createView(),
            'newsletter' => $newsletter,
        ));
    }

    public function deleteAction(Request $request, $id){
        $em = $this->getDoctrine()->getManager();

        $newsletter = $em->getRepository('CmsBundle:Newsletter')->findOneById($id);

        if ($newsletter == null){
            $request->getSession()
                ->getFlashBag()
                ->add('error',  'Pas de newsletter associer')
            ;

            $url = $this->generateUrl('newsletters_show');
            return $this->redirect($url);
        }

        $em->remove($newsletter);
        if ($newsletter->getFilename() != null)
            $newsletter->removeUpload();
        $em->flush();

        return $this->redirectToRoute('newsletters_show');
    }

    protected function getUsersMail(){
        $em = $this->getDoctrine()->getManager();
        $users_actifs = $em->getRepository('CmsBundle:AbonnementNews')->findBy(array('etat' => true));
        $destinataires = '';

        foreach ($users_actifs as $key => $user){
            if ($destinataires == '')
                $destinataires = $user->getEmail();
            else
                $destinataires .= ', ' . $user->getEmail();
        }
        return explode(", ", $destinataires);
    }
    public function sendMailAction(Newsletter $newsletter){

        $em = $this->getDoctrine()->getManager();
        $destinataires = $this->getUsersMail();
        $file = $newsletter->getWebPath();
        $desabonnement = '<p style="margin-top: 60px; text-align: center;">Pour vous desabonner, <a href="' . __DIR__ . $this->generateUrl('newsletter_desabonnement') .'">cliquez ici</a><p>';

        if ($newsletter->getFilename() != null){
            $message = \Swift_Message::newInstance()
                ->setSubject($newsletter->getObjet())
                ->setFrom(array($this->getParameter('mailer_user') => 'Jeux de Dames'))
                ->setTo($destinataires)
                ->setBody(
                    $newsletter->getTexte() .
                    $desabonnement, 'text/html')
                ->attach(\Swift_Attachment::fromPath($file));
        }
        else{
            $message = \Swift_Message::newInstance()
                ->setSubject($newsletter->getObjet())
                ->setFrom(array($this->getParameter('mailer_user') => 'Jeux de Dames'))
                ->setTo($destinataires)
                ->setBody(
                    $newsletter->getTexte() .
                    $desabonnement, 'text/html');
        }


        $this->get('mailer')->send($message);

        $newsletter->setEtat(true);

        $em->persist($newsletter);
        $em->flush();

        return $this->redirectToRoute('newsletters_show');
    }

}

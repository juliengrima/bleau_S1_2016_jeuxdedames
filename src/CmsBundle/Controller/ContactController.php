<?php

namespace CmsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends Controller
{
    public function sendAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $emails = $em->getRepository('CmsBundle:Apropos')->findAll();

        foreach ($emails as $email){
            $mail_jdd = $email->getEmailcontact();
        }

        $name = $request->request->get('nom');
        $mail = $request->request->get('email');
        $sujet = $request->request->get('sujet');
        $message = $request->request->get('message');

        $message = \Swift_Message::newInstance()
            ->setSubject('Contact Jeux de dames')
            ->setFrom($mail)
            ->setTo($mail_jdd)
            ->setBody(
                $this->renderView(
                    '@Cms/contact.html.twig',
                    array(
                        'nom' => $name,
                        'email' => $mail,
                        'sujet' => $sujet,
                        'message' => $message
                        )
                ),
                'text/html'
            )
        ;
        $this->get('mailer')->send($message);

        return $this->redirectToRoute('user_apropos');
    }
}

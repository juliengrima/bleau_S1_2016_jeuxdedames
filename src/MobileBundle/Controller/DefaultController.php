<?php

namespace MobileBundle\Controller;

use CmsBundle\CmsBundle;
use MobileBundle\Entity\MobileList;
use CmsBundle\Entity\Artiste;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Date;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Validator\Constraints\DateTime;

class DefaultController extends Controller
{

    public function getJsonAction() {

//      Recupération et filtrage via Services
        $mobileList = $this->container->get('mobile.service')->getjsonArtistesFalse ();

        $normalizer = new ObjectNormalizer(); //Normalisation des données pour passer en JSON
        $encoder = new JsonEncoder(); // Encodage des données en JSON

        /* ENCODAGE DE DATE POUR RECUP */
        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d m Y')
                : '';
        };

        /* CREATION TABLEAU POUR ENVOI AU JSON */
        $normalizer->setCallbacks(array('dateDebut' => $dateCallback, 'dateFin' => $dateCallback, 'date' => $dateCallback));
        $normalizer->setIgnoredAttributes(array ('artiste'));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileList, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;

    }

    public function getJsoneventsAction() {

        $em = $this->getDoctrine()->getManager();
        $mobileList = $em->getRepository('CalendarBundle:Events')->findAll ();

        $normalizer = new ObjectNormalizer(); //Normalisation des données pour passer en JSON
        $encoder = new JsonEncoder(); // Encodage des données en JSON

        /* ENCODAGE DE DATE POUR RECUP */
        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d m Y H:i')
                : '';
        };

        /* CREATION TABLEAU POUR ENVOI AU JSON */
        $normalizer->setCallbacks(array('start' => $dateCallback, 'end' => $dateCallback));
        $normalizer->setIgnoredAttributes(array ('artiste'));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileList, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;
    }
}

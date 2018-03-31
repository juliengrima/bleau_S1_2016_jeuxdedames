<?php

namespace MobileBundle\Controller;

use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

//    APPEL DE LA BASE MOBLE_LIST EN FONCTION DE ARTISTE

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
        $normalizer->setCallbacks(array('dateDebut' => $dateCallback, 'dateFin' => $dateCallback));
        $normalizer->setIgnoredAttributes(array ('artiste'));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileList, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;

    }

        //    APPEL DE LA BASE MOBLE_LIST EN FONCTION DE CATEGORIE

    public function getJsonJobAction() {

//      Recupération et filtrage via Services
        $mobileList = $this->container->get('mobile.service')->getjsonJob ();

        $normalizer = new ObjectNormalizer(); //Normalisation des données pour passer en JSON
        $encoder = new JsonEncoder(); // Encodage des données en JSON

        /* ENCODAGE DE DATE POUR RECUP */
        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format('d m Y')
                : '';
        };

        /* CREATION TABLEAU POUR ENVOI AU JSON */
        $normalizer->setCallbacks(array('dateDebut' => $dateCallback, 'dateFin' => $dateCallback));
        $normalizer->setIgnoredAttributes(array ('artiste'));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileList, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;

    }

    public function getJsonCommercantAction() {

//      Recupération et filtrage via Services
        $mobileList = $this->container->get('mobile.service')->getjsonCommercant ();

//        $em = $this->getDoctrine ()->getManager ();
//        $mobileList = $em->getRepository ('MobileBundle:MobileList')->findAll ();

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

//    ------------------------------------------------------------------------------------------------------

    public function getJsoneventsAction() {

        $day = new DateTime('now');
        $day->format (' Y-m-d H:i');

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

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileList, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;
    }

}

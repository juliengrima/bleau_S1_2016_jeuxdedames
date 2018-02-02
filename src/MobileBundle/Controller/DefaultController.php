<?php

namespace MobileBundle\Controller;

use MobileBundle\Entity\MobileList;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{

    public function getJsonAction() {

        $em = $this->getDoctrine()->getManager();
        $mobileLists = $em->getRepository('MobileBundle:MobileList')->findAll();

        $normalizer = new ObjectNormalizer(); //Normalisation des données pour passer en JSON
        $encoder = new JsonEncoder(); // Encodage des données en JSON

        /* ENCODAGE DE DATE POUR RECUP */
        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format(\DateTime::ISO8601)
                : '';
        };

        /* CREATION TABLEAU POUR ENVOI AU JSON */
        $normalizer->setCallbacks(array('dateDebut' => $dateCallback, 'dateFin' => $dateCallback));
//        $normalizer->setIgnoredAttributes(array('commercant', 'artiste'));
        $normalizer->setCircularReferenceHandler(function ($mobileLists) {
            return $mobileLists->getName ('commercant');
        });

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($mobileLists, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;
    }
}

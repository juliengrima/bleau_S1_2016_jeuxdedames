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
    public function homeAction()
    {

        $em = $this->getDoctrine()->getManager();
        $mobileLists = $em->getRepository('MobileBundle:MobileList')->findAll();

        if ($mobileLists != ''){

            $normalizer = new ObjectNormalizer(); //Normalisation des données pour passer en JSON
            $normalizer->setIgnoredAttributes(array('commercant', 'artiste'));
            $encoder = new JsonEncoder(); // Encodage des données en JSON
            $serializer = new Serializer(array($normalizer), array($encoder));

            $jsonObject = $serializer->serialize($mobileLists, 'json');

            $content = $this->renderView('@Mobile/mobilelist/content.html.twig', array(
                'mobileLists'=>$mobileLists
            ));
            $response = new JsonResponse($content);

            return $response;

        }

        return $this->render('MobileBundle:Default:index.html.twig');
    }
}

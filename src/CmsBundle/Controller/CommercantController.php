<?php

namespace CmsBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CmsBundle\Entity\Commercant;
use CmsBundle\Form\CommercantType;

/**
 * Commercant controller.
 *
 */
class CommercantController extends Controller
{
    /**
     * Lists all Commercant entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $commercants = $em->getRepository('CmsBundle:Commercant')->findAll();

        return $this->render('CmsBundle:commercant:index.html.twig', array(
            'commercants' => $commercants,
        ));
    }

    /**
     * Creates a new Commercant entity.
     *
     */
    public function newAction(Request $request)
    {
        $commercant = new Commercant();
        $form = $this->createForm('CmsBundle\Form\CommercantType', $commercant);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

//          Récupération lat et lng de l'adresse'
            $rue = $form->getData()->getAdresse();
            $code = $form->getData()->getCode();
            $ville = $form->getData()->getVille();

            $lat_lng = $this->getLatLng($rue, $code, $ville);

            $commercant->setLat($lat_lng['lat']);
            $commercant->setLng($lat_lng['lng']);

            $em = $this->getDoctrine()->getManager();
            $em->persist($commercant);
            $em->flush();

            return $this->redirectToRoute('commercant_index');
        }

        return $this->render('CmsBundle:commercant:new.html.twig', array(
            'commercant' => $commercant,
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Commercant entity.
     *
     */
    public function editAction(Request $request, Commercant $commercant)
    {
        $editForm = $this->createForm('CmsBundle\Form\CommercantType', $commercant);

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

                // Récupération lat et lng de l'adresse'
                $rue = $editForm->getData()->getAdresse();
                $code = $editForm->getData()->getCode();
                $ville = $editForm->getData()->getVille();

                $lat_lng = $this->getLatLng($rue, $code, $ville);
                $commercant->setLat($lat_lng['lat']);
                $commercant->setLng($lat_lng['lng']);

            if($editForm->get('file')->getData() != null) {

                if($commercant->getImage() != null) {
                    unlink(__DIR__.'/../../../web/uploads/imgcms/'.$commercant->getImage());
                    $commercant->setImage(null);
                }
            }
            $commercant->preUpload();
            $em->persist($commercant);
            $em->flush();

            return $this->redirectToRoute('commercant_index');
        }

        return $this->render('@Cms/commercant/edit.html.twig', array(
            'commercant' => $commercant,
            'form' => $editForm->createView(),
        ));
    }


    /**
     * Remove an existing record and a file.
     *
     */
    public function deleteAction($id) {
        $em = $this->getDoctrine()->getManager();
        $commercant = $em->getRepository('CmsBundle:Commercant')->findOneById($id);

        if (!$commercant) {
            throw $this->createNotFoundException(
                'Pas de commerçant trouvé'
            );
        }
        $em->remove($commercant);
        $em->flush();

        return $this->redirectToRoute('commercant_index');
    }

    public function getLatLng($rue, $code_postal, $ville){

        $rue = str_replace(" ", "%20", $rue);
        $url = "http://maps.googleapis.com/maps/api/geocode/json?address=". $rue . "%20" . $code_postal . "%20" . $ville . "&sensor=true";

        $result_string = file_get_contents($url);

        $result = json_decode($result_string, true);

        $location['lat'] = $result['results'][0]['geometry']['location']['lat'];
        $location['lng'] = $result['results'][0]['geometry']['location']['lng'];

        return $location;
    }
}

<?php

namespace CalendarBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use CalendarBundle\Entity\Events;
use CalendarBundle\Form\EventsType;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

/**
 * Events controller.
 *
 */
class EventsController extends Controller
{
    public function showAllEventsAction(){
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('CalendarBundle:Events')->findBy(array(), array('start' => 'desc'));

        return $this->render('@Calendar/events/index.html.twig', array(
            'events' => $events
        ));
    }

    /**
     * Lists all Events entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('CalendarBundle:Events')->findAll();

        $normalizer = new ObjectNormalizer();

        $encoder = new JsonEncoder();

        $dateCallback = function ($dateTime) {
            return $dateTime instanceof \DateTime
                ? $dateTime->format(\DateTime::ISO8601)
                : '';
        };

        $normalizer->setCallbacks(array('start' => $dateCallback, 'end' => $dateCallback));

        $serializer = new Serializer(array($normalizer), array($encoder));
        $jsonObject = $serializer->serialize($entities, 'json');

        $response = new Response();
        $response->setContent($jsonObject);

        return $response;
    }

    /**
     * Creates a new Events entity.
     *
     */
    public function newAction(Request $request, $start)
    {
        $event = new Events();
        if ($start == 0) {
            $newTime = new \DateTime();
            $startEvent = $newTime->format('d-m-Y H:i:s');
            $event->setStart(new \DateTime($startEvent));
            $endtime = new \DateTime();
            $endEvent = $endtime->format('d-m-Y H:i:s');
            $event->setEnd(new \DateTime($endEvent));
        }
        else {
            $event->setStart(new \DateTime($start));
            $event->setEnd(new \DateTime($start));
        }

        $form = $this->createForm('CalendarBundle\Form\EventsType', $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('calendar_homepage');
        }

        return $this->render('CalendarBundle:events:new.html.twig', array(
            'event' => $event,
            'form' => $form->createView(),
        ));
    }
    
    /**
     * Displays a form to edit an existing Events entity.
     *
     */
    public function editAction(Request $request, Events $event)
    {
        $editForm = $this->createForm('CalendarBundle\Form\EventsType', $event);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($event);
            $em->flush();

            return $this->redirectToRoute('calendar_homepage', array('id' => $event->getId()));
        }

        return $this->render('CalendarBundle:events:edit.html.twig', array(
            'event' => $event,
            'edit_form' => $editForm->createView(),
            ));
    }

    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $event = $em->getRepository('CalendarBundle:Events')->findOneById($id);
        $img_evenement = $em->getRepository('CmsBundle:Images')->findOneById($event->getImages()->getId());

        if (!empty($event))
        {
            $em->remove($img_evenement);
            $em->remove($event);
            $em->flush();
        }

        return $this->redirectToRoute('calendar_homepage');
    }
}

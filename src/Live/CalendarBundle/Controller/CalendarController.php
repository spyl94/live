<?php

namespace Live\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

use Live\CalendarBundle\Entity\Event;

/**
 * Calendar controller.
 *
 * @Route("/calendar")
 */
class CalendarController extends Controller
{
    /**
     * @Route("/", name="calendar")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/events", name="getEventData")
     */
    public function getEventDataAction()
    {
        $tab = array();
        $repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
        $events = $repository->findAll();

        foreach ($events as $key => $value) {
            $tab[$key] = array (
                "id" => $value->getId(),
                "start" => $value->getStart(),
                "end" => $value->getEnd(),
                "title" => $value->getTitle(),
                "validate" => $value->getValidate(),
                "readOnly" => $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY') &&
                ($value->getCreator() == $this->getUser() || $this->get('security.context')->isGranted('ROLE_TEAM')) ? false : true,
                "refused" => $value->getRefused(),
                "creator" => $value->getCreator()->getUsername()
            );
        }
        return new Response(json_encode($tab));
    }

    /**
     * @Route("/events/new", name="addEvent")
     */
    public function addEventAction()
    {
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()) {

            if ($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {

                //$start = date_create_from_format('D M d Y H:i:s e+', $request->request->get('start') );
                //$end = date_create_from_format('D M d Y H:i:s e+', $request->request->get('end') );
                $start = new \DateTime($request->request->get('start'),new \DateTimeZone("Europe/Paris"));
                $end = new \DateTime($request->request->get('end'),new \DateTimeZone("Europe/Paris"));

                if ($start < $end && new \DateTime() < $start) {

                    $event = new Event();
                    $event->setStart($request->request->get('start'));
                    $event->setEnd($request->request->get('end'));
                    $event->setTitle($request->request->get('title'));
                    $event->setValidate(false);
                    $event->setRefused(false);
                    $user = $this->getUser();
                    $event->setCreator($user);
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($event);
                    $em->flush();
                    return new Response("La réservation a été ajoutée avec succès !");
                }
                return new JsonResponse(array('msg' => 'Impossible d\'effectuer une réservation dans le passé !'), 419);
            }
            return new JsonResponse(array('msg' => 'Pour effectuer une réservation, vous devez vous connecter !'), 419);
        }
        return new Response();
    }

    /**
     * @Route("/events/edit", name="editEvent")
     */
    public function editEventAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {

            $repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
            $event = $repository->findOneById($request->request->get('eventID'));

            if (!$event) {
                return new JsonResponse(array('msg' => "Cet évenement est introuvable !"), 419);
            }

            if ($this->get('security.context')->isGranted('ROLE_TEAM') || (
                $event->getCreator() == $this->getUser() &&
                new \DateTime() < new \DateTime($request->request->get('start'))
            )) {

                $event->setStart($request->request->get('start'));
                $event->setEnd($request->request->get('end'));
                $event->setTitle($request->request->get('title'));
                $event->setValidate(false);
                $event->setRefused(false);

                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return new Response("Modification effectuée avec succès !");
            }
            return new JsonResponse(array('msg' => "Vous ne pouvez pas modifier cet évent !"), 419);
        }
        return new Response();
    }


    /**
     * @Route("/events/delete", name="removeEvent")
     */
    public function removeEventAction()
    {
        $request = $this->getRequest();

        if ($request->isXmlHttpRequest()) {

            $repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
            $event = $repository->findOneById($request->request->get('eventID'));

            if (!$event) {
                return new JsonResponse(array('msg' => "Cet évenement est introuvable !"), 419);
            }

            if ($this->get('security.context')->isGranted('ROLE_TEAM') || $event->getCreator() == $this->getUser()) {

                $em = $this->getDoctrine()->getManager();
                $em->remove($event);
                $em->flush();
                return new Response("La réservation a été supprimée avec succès !");
            }
            return new JsonResponse(array('msg' => "Vous ne pouvez pas supprimer cet évenement !"), 419);
        }
        return new Response();
    }


    /**
     * @Route("/events/validate", name="validateEvent")
     */
    public function validateEventAction()
    {
        $request = $this->getRequest();

        if($request->isXmlHttpRequest()) {

            $repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
            $event = $repository->findOneById($request->request->get('eventID'));

            if (!$event) {
                return new JsonResponse(array('msg' => "Cet évenement est introuvable !"), 419);
            }

            if ($this->get('security.context')->isGranted('ROLE_TEAM')) {

                $event->setValidate(true);
                $event->setRefused(false);
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return new Response("La réservation a été validée avec succès !");
            }
            return new JsonResponse(array('msg' => "Vous ne pouvez pas valider cet évenement !"), 419);
        }
        return new Response();
    }

    /**
     * @Route("/events/refuse", name="refusedEvent")
     */
    public function refusedEventAction()
    {
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()) {

            $repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
            $event = $repository->findOneById($request->request->get('eventID'));

            if (!$event) {
                return new JsonResponse(array('msg' => "Cet évenement est introuvable !"), 419);
            }

            if ($this->get('security.context')->isGranted('ROLE_TEAM')) {

                $event->setValidate(false);
                $event->setRefused(true);
                $em = $this->getDoctrine()->getManager();
                $em->persist($event);
                $em->flush();
                return new Response("La réservation a été refusée avec succès !");
            }
            return new JsonResponse(array('msg' => "Vous ne pouvez pas refuser cet évenement !"), 419);
        }
        return new Response();
    }
}

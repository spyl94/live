<?php

namespace Live\CalendarBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;
use Live\CalendarBundle\Entity\Event;

class DefaultController extends Controller
{
    /**
     * @Route("/calendar")
     * @Template()
     */
    public function indexAction()
    {
        return $this->render('LiveCalendarBundle:Calendar:calendar.html.twig');
    }

	/**
	 * @Route("/calendar/getEventData", name="getEventData")
	 * @Template()
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
    			"validate" => $value->getValidate()
    			);
    	}
    	return new Response(json_encode($tab));
    }

    /**
	 * @Route("/calendar/addEvent", name="addEvent")
	 * @Template()
	 */
    public function addEventAction()
    {

    	$request = $this->getRequest();
		if($request->isXmlHttpRequest()) {

			if (true === $this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) {

		    	$event = new Event();
			    $event->setStart($request->request->get('start'));
			    $event->setEnd($request->request->get('end'));
			    $event->setTitle($request->request->get('title'));
			    $event->setValidate(false);
			    $user = $this->getUser();
			    $event->setCreator($user);
			    $em = $this->getDoctrine()->getManager();
			    $em->persist($event);
			    $em->flush();
			    return new Response("La réservation a été ajoutée avec succès !");
			}
			return new Response("Pour effectuer une réservation, vous devez vous connecter !");
		}
		return new Response();
    }

    /**
	 * @Route("/calendar/editEvent", name="editEvent")
	 * @Template()
	 */
    public function editEventAction()
    {

    	$request = $this->getRequest();
		if($request->isXmlHttpRequest()) {

			$repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
	    	$event = $repository->findOneById($request->request->get('eventID'));
	    	if($event && (true === $this->get('security.context')->isGranted('IS_ADMIN') || $event->getCreator() == $this->getUser())) {
	    		$event->setStart($request->request->get('start'));
			    $event->setEnd($request->request->get('end'));
			    $event->setTitle($request->request->get('title'));
			    $event->setValidate(false);

			    $em = $this->getDoctrine()->getManager();
			    $em->persist($event);
			    $em->flush();
			    return new Response("Modification effectuée avec succès !");
	    	}
	    	return new Response("Vous ne pouvez pas modifier cet évent !");
		}
		return new Response("");
    }


    /**
	 * @Route("/calendar/removeEvent", name="removeEvent")
	 * @Template()
	 */
    public function removeEventAction()
    {

    	$request = $this->getRequest();
		if($request->isXmlHttpRequest()) {

			$repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
	    	$event = $repository->findOneById($request->request->get('eventID'));
	    	if($event && (true === $this->get('security.context')->isGranted('IS_ADMIN') || $event->getCreator() == $this->getUser())) {
	    		$em = $this->getDoctrine()->getManager();
			    $em->remove($event);
			    $em->flush();
			    return new Response("La réservation a été supprimée avec succès !");
	    	}
	    	return new Response("Vous ne pouvez pas supprimer cet évenement !");
		}
		return new Response();
    }


    /**
	 * @Route("/calendar/validateEvent", name="validateEvent")
	 * @Template()
	*/
    public function validateEventAction()
    {
    	$request = $this->getRequest();
		if($request->isXmlHttpRequest()) {

			$repository = $this->getDoctrine()->getRepository('LiveCalendarBundle:Event');
	    	$event = $repository->findOneById($request->request->get('eventID'));
	    	if($event) {
	    		$event->setValidate(true);
	    		$em = $this->getDoctrine()->getManager();
			    $em->persist($event);
			    $em->flush();
			    return new Response("La réservation a été validée avec succès !");
	    	}
		}
		return new Response();
    }


}

<?php

namespace Live\UserBundle\EventListener;

use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Event\FormEvent;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Doctrine\ORM\EntityManager;

class RegistrationListener implements EventSubscriberInterface
{
    /** @var \Doctrine\ORM\EntityManager */
    protected $em;

    /** @var Symfony\Component\Routing\Generator\UrlGeneratorInterface */
    private $router;

    function __construct(EntityManager $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return array(
            FOSUserEvents::REGISTRATION_SUCCESS => 'onRegistrationSuccess',
        );
    }

    public function onRegistrationSuccess(FormEvent $event)
    {
        $user = $event->getForm()->getData();

        $instruments = $this->em->getRepository('LiveLessonBundle:Instrument')->getInstrumentsLowLevel();

        $user->setInstruments($instruments);

        $this->em->persist($user);
        $this->em->flush();

        $url = $this->router->generate('fos_user_profile_edit');

        $event->setResponse(new RedirectResponse($url));
    }

}

<?php

namespace Live\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class UserController extends Controller
{
    /**
     * @Route("/users/{slug}", name="users_view")
     * @Template()
     */
    public function viewAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('LiveUserBundle:User')->findOneByUsernameCanonical($slug);

        if (!$user) {
            throw $this->createNotFoundException('Impossible de trouver cet utilisateur !');
        }
        $lessons = $em->getRepository('LiveLessonBundle:Lesson')->findByCreator($user, array('createdAt' => 'asc'));
        $asks = $em->getRepository('LiveLessonBundle:LessonAsk')->findByCreator($user, array('createdAt' => 'asc'));

        return array(
            'user' => $user,
            'lessons' => $lessons,
            'asks' => $asks
        );
    }

    /**
     * @Template()
     */
    public function instrumentsAction($user, $limit, $offset)
    {
        $instruments = $user->getInstruments();

        if ($instruments->isEmpty()) {
            $em = $this->getDoctrine()->getManager();
            $instruments = $em->getRepository('LiveLessonBundle:Instrument')->getInstrumentsLowLevel();
            $user->setInstruments($instruments);
            $em->flush();
        }

        return array(
            'instruments' => $instruments,
            'length' => $limit,
            'start' => $offset,
        );
    }

}




<?php

namespace Live\LessonBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Live\LessonBundle\Entity\Instrument;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends Controller
{
    /**
     * Edits an existing Instrument entity.
     *
     * @Route("/instruments/edit", name="instrument_update")
     */
    public function updateInstrumentAjaxAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {

            $name = $request->request->get('name');
            $level = $request->request->get('level');

            $em = $this->getDoctrine()->getManager();

            $instrument = $em->getRepository('LiveLessonBundle:Instrument')->findOneBy(array('name' => $name, 'level' => $level));

            if (!$instrument) {
                return new JsonResponse(array('msg' => "Instrument introuvable !"), 419);
            }

            $user = $this->getUser();
            $instruments = $user->getInstruments();

            foreach ($instruments as $i) {
               if ($i->getName() == $name) $user->removeInstrument($i);
            }

            $user->addInstrument($instrument);
            $em->flush();

            return new Response("OK");
        }
        return new Response("");
    }
}

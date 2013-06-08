<?php

namespace Live\MainBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\RedirectResponse;


class DefaultController extends Controller
{
    /**
     * @Route("/about", name="about")
     * @Template()
     */
    public function aboutAction()
    {
       return new RedirectResponse($this->generateUrl('calendar'));
    }

}




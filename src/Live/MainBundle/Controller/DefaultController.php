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
       return array();
    }

   /**
     * @Route("/about/local", name="about_local")
     * @Template()
     */
    public function localAction()
    {
       return array();
    }

    /**
     * @Route("/about/team", name="about_team")
     * @Template()
     */
    public function teamAction()
    {
       return array();
    }

}




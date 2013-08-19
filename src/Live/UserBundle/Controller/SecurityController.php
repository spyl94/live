<?php

namespace Live\UserBundle\Controller;

use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityController extends BaseController
{

    protected function renderLogin(array $data)
    {
        $template = sprintf('FOSUserBundle:Security:login.html.%s', $this->container->getParameter('fos_user.template.engine'));

        $data['registration'] = $this->container->get('fos_user.registration.form.factory')->createForm()->createView();

        return $this->container->get('templating')->renderResponse($template, $data);
    }

}

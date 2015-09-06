<?php

namespace UserBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\SecurityContext;
use FOS\UserBundle\Controller\SecurityController as BaseController;

class SecurityAdminController extends BaseController
{

    protected function renderLogin(array $data)
    {

        return $this->container->get('templating')->renderResponse('AdminBundle:Security:login.html.twig', $data);
    }


}


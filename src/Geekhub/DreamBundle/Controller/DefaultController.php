<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('DreamBundle:Default:index.html.twig', array('name' => $name));
    }
}

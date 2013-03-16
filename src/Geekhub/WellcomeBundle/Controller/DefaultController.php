<?php

namespace Geekhub\WellcomeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('WellcomeBundle:Default:index.html.twig');
    }
}

<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->get('security.context')->getToken()->getUser();
        $dreams = $this->getDoctrine()->getRepository('DreamBundle:Dream')->findBy(array(), array('like' => 'DESC'), 6);

        return $this->render('DreamBundle:Default:index.html.twig', array(
            'user' => $user,
            'dreams' => $dreams
        ));
    }
}

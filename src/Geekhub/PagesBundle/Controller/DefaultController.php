<?php

namespace Geekhub\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function faqAction()
    {
        $faqs = $this->getDoctrine()->getManager()->getRepository('PagesBundle:Faq')->findAll();
        return $this->render('PagesBundle:Default:faq.html.twig', array(
            'faqs' => $faqs,
        ));
    }

    public function contactsAction()
    {
        $contacts = $this->getDoctrine()->getManager()->getRepository('PagesBundle:Contact')->findAll();
        return $this->render('PagesBundle:Default:contacts.html.twig', array(
            'contacts' => $contacts,
        ));
    }
}

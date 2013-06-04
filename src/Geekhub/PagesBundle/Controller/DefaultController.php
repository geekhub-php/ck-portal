<?php

namespace Geekhub\PagesBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    public function faqAction()
    {
        $faqs = $this->getDoctrine()->getManager()->getRepository('PagesBundle:Faq')->findAll();
        return $this->render('PagesBundle:Default:faq.html.twig', array(
            'faqs' => $faqs,
        ));
    }

    public function contactsAction(Request $request)
    {
        $contacts = $this->getDoctrine()->
            getManager()->
            getRepository('PagesBundle:Contact')->
            findBy(array(), array('position' => 'ASC'));

        $form = $this->createFormBuilder()
            ->add('email', 'email', array('label' => 'Адреса для зворотнього зв’язку'))
            ->add('theme', 'text', array('label' => 'Тема листа'))
            ->add('text', 'textarea', array('label' => 'Текст повідомлення'))
            ->add('captcha', 'text', array('label' => 'Капча'))
            ->getForm();
        ;

        if ($request->isMethod('POST')) {
            $form->bind($request);

            if ($form->isValid()) {

                $formData = $form->getData();
//                var_dump($formData); exit;
                $message = \Swift_Message::newInstance()
                    ->setSubject($formData['theme'])
                    ->setFrom($formData['email'])
                    ->setTo($this->container->getParameter('delivery_address'))
                    ->setBody($formData['text'])
                ;
                $this->get('mailer')->send($message);

                return $this->render('PagesBundle:Default:contacts.html.twig', array(
                    'contacts' => $contacts,
                    'form'     => $form->createView()
                ));
            }
        }

        return $this->render('PagesBundle:Default:contacts.html.twig', array(
            'contacts' => $contacts,
            'form'     => $form->createView()
        ));
    }
}

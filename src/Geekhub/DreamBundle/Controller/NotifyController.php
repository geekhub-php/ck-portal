<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Geekhub\DreamBundle\Entity\Dream;

class NotifyController extends Controller
{
    public function setAjaxDreamSuccessAction($dreamId)
    {
        $securityContext = $this->container->get('security.context');
        $em = $this->getDoctrine()->getManager();
        /** @var $dream Dream */
        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);

        if (!$dream) {
            return $this->prepareAjaxResponse('error', 'Unable to find Dream entity');
        }
        elseif ($securityContext->getToken()->getUser()->getId() != $dream->getOwner()->getId()) {
            return $this->prepareAjaxResponse('error', 'Edit this dream can only it owner');
        }
        elseif (false == $this->getRequest()->isXmlHttpRequest())
        {
            return $this->prepareAjaxResponse('error', 'Only ajax request can be send');
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Зміна статусу мрії '.$dream->getTitle())
            ->setFrom('noreplay@chedream.com')
            ->setTo('noreplay@chedream.com')
            ->setBody(
            $this->renderView(
                'DreamBundle:Email:dreamSuccess.html.twig',
                array('dream' => $dream)
            )
        )
        ;
        $this->get('mailer')->send($message);

        return $this->prepareAjaxResponse('success', 'Мрію буде переведено в статус збору коштів після перевірки адміністратором');
    }

    /**
     * @param $type string type of message - error, success
     * @param $message string message
     * @param $format string type of response format - json, xml
     * @return $response Response
     */
    private function prepareAjaxResponse($type, $message, $format = 'json')
    {
        $answer = array($type => $message);
        $jsonError = $this->container->get('serializer')->serialize($answer, $format);
        $response = new Response($jsonError);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }
}
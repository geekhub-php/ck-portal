<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\UserBundle\Entity\User;

class NotifyController extends Controller
{
    public function setAjaxDreamSuccessAction($dreamId)
    {
        if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->prepareAjaxResponse(array('error' => 'Only authenticated user can edit dream'));
        }

        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);

        $error = $this->validationRequest($dream, $user);

        if ($error) {
            return $this->prepareAjaxResponse($error);
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Зміна статусу мрії '.$dream->getTitle())
            ->setFrom('noreplay@chedream.com')
            ->setTo('noreplay@chedream.com')
            ->setBody(
                $this->renderView(
                    'DreamBundle:Email:dreamSuccess.html.twig',
                    array(
                        'dream' => $dream,
                        'user' => $user,
                    )
                )
            )
        ;
        $this->get('mailer')->send($message);

        return $this->prepareAjaxResponse(array('success' => 'Мрію буде переведено в статус збору коштів після перевірки адміністратором'));
    }

    public function setAjaxDreamCloseAction(Request $request)
    {
        if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->prepareAjaxResponse(array('error' => 'Only authenticated user can edit dream'));
        }

        $user = $this->container->get('security.context')->getToken()->getUser();
        $em = $this->getDoctrine()->getManager();
        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($request->get('dreamId'));

        $error = $this->validationRequest($dream, $user);

        if ($error) {
            return $this->prepareAjaxResponse($error);
        }

        $message = \Swift_Message::newInstance()
            ->setSubject('Зміна статусу мрії '.$dream->getTitle())
            ->setFrom('noreplay@chedream.com')
            ->setTo('noreplay@chedream.com')
            ->setBody(
                $this->renderView(
                    'DreamBundle:Email:dreamClose.html.twig',
                    array(
                        'dream'     => $dream,
                        'user'      => $user,
                        'reason'    => $request->get('reason'),
                    )
                )
            )
        ;
        $this->get('mailer')->send($message);

        return $this->prepareAjaxResponse(array('success' => 'Мрію буде закрито після перевірки адміністратором'));
    }

    /**
     * @param $answer array message ('error' => 'This error')
     * @param $format string type of response format - json, xml
     * @return $response Response
     */
    private function prepareAjaxResponse($answer, $format = 'json')
    {
        $jsonError = $this->container->get('serializer')->serialize($answer, $format);
        $response = new Response($jsonError);
        $response->headers->set('Content-Type', 'application/json');

        return $response;
    }

    private function validationRequest(Dream $dream, User $user)
    {
        if (!$dream) {
            return array('error' => 'Unable to find Dream entity');
        }
        elseif ($user->getId() != $dream->getOwner()->getId()) {
            return array('error' => 'Edit this dream can only it owner');
        }
        elseif (false == $this->getRequest()->isXmlHttpRequest())
        {
            return array('error' => 'Only ajax request can be send');
        }
    }
}
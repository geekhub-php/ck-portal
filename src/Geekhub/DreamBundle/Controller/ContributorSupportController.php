<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Geekhub\DreamBundle\Entity\ContributorSupport;

/**
 * ContributorSupport controller.
 *
 */
class ContributorSupportController extends Controller
{
    /**
     * Creates a new ContributorSupport entity.
     *
     */
    public function setAjaxDonateAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        $dream = $this->getDoctrine()->getRepository('DreamBundle:Dream')->findOneById($request->get('dreamId'));

        if (false == $this->getRequest()->isXmlHttpRequest())
        {
            return $this->prepareAjaxResponse(array('error' => 'Only ajax request can be send'));
        }
        elseif (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->prepareAjaxResponse(array('error' => 'Only authenticated user can make donate'));
        }
        elseif ($securityContext->getToken()->getUser()->getId() == $dream->getOwner()->getId()) {
            return $this->prepareAjaxResponse(array('error' => 'You are owner. You don\'t can to contribute your own dream'));
        }


        $points = $this->get('geekhub.dream_bundle.point_manager')->getPointEntityFromRequest($request, $dream);

        foreach ($points as $point) {
            $validator = $this->get('validator');
            $errors = $validator->validate($point);

            if (count($errors) > 0) {
                return new Response(print_r($errors, true));
            } else {
                $em = $this->getDoctrine()->getManager();
                $em->persist($point);
                $em->flush();
            }
        }

        return $this->prepareAjaxResponse(array('success' => true));
    }

    public function getAjaxTabsAction($dreamId)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);
        $contributorsArray = $this->get('geekhub.dream_bundle.dream_manager')->getContributorsArray($dream);

        return $this->render('DreamBundle:Dream:tabs.html.twig', array(
            'dream'                 => $dream,
            'contributorsArray'     => $contributorsArray,
        ));
    }

    public function updateAjaxProgressBarAction($dreamId)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);
        $newProgressBar = $this->get('geekhub.dream_bundle.dream_manager')->getNewProgressBar($dream);

        $em->persist($newProgressBar);
        $em->flush();

        return $this->render('DreamBundle:Dream:progressBar.html.twig', array(
            'progressBar'                 => $newProgressBar,
        ));
    }

    public function getAjaxProgressBarAction($dreamId)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);

        return $this->render('DreamBundle:Dream:progressBar.html.twig', array(
            'progressBar'                 => $dream->getProgressBar(),
        ));
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
}

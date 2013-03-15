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
        if (false == $this->getRequest()->isXmlHttpRequest())
        {
            return new Response(array('error' => 'Only ajax request can be send'));
        }

        $securityContext = $this->container->get('security.context');
        if (!$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return new Response(array('error' => 'Only authenticated user can make donate'));
        }

        $dream = $this->getDoctrine()->getRepository('DreamBundle:Dream')->findOneById($request->get('dreamId'));
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

        return new Response(var_dump($points));
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

}

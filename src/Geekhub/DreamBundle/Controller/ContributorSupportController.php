<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

use Geekhub\DreamBundle\Entity\ContributorSupport;
use Geekhub\DreamBundle\Form\ContributorSupportType;

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

        $cb  = new ContributorSupport();
        $dream = $this->getDoctrine()->getRepository('DreamBundle:Dream')->findOneById($request->get('dreamId'));
        $point = $this->get('geekhub.dream_bundle.point_manager')->getPointEntityFromRequest($request, $dream);

        $cb->setDream($dream);
        $cb->setContributeItem($point);
        $cb->setHide($request->get('hide'));
        $cb->setUser($securityContext->getToken()->getUser());

        $validator = $this->get('validator');
        $errors = $validator->validate($cb);

        if (count($errors) > 0) {
            return new Response(print_r($errors, true));
        } else {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cb);
            $em->flush();
        }

$entity = $request->get('entity');
        return new Response(var_dump($point));
    }

    public function getAjaxTabsAction($dreamId)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);
        $contributions = $em->getRepository('DreamBundle:ContributorSupport')->findByDream($dream);
        $contributorsArray = $this->get('geekhub.dream_bundle.dream_manager')->getContributorsArray($contributions);

        return $this->render('DreamBundle:Dream:tabs.html.twig', array(
            'dream'                 => $dream,
            'contributorsArray'     => $contributorsArray,
        ));
    }

}

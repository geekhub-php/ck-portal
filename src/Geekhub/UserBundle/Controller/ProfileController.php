<?php

namespace Geekhub\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\HttpFoundation\Response;

use Geekhub\UserBundle\Entity\User;
use Behat\Gherkin\Node\TableNode;

class ProfileController extends Controller
{
    public function showMyProfileAction()
    {
        $user= $this->getUser();

        if (!$this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
            return $this->redirect($this->generateUrl('fos_user_security_login'));
        }

        $contributorsArray = $this->get('geekhub.user_bundle.user_manager')->getContributedDreams($user, true);

        return $this->render('UserBundle:Profile:showMy.html.twig', array(
            'user'              => $user,
            'contributorsArray' => $contributorsArray,
        ));
    }

    public function showStrangerProfileAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $user User */
        $user = $em->getRepository('UserBundle:User')->findOneBySlug($slug);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
        elseif($this->container->get('security.context')->isGranted('IS_AUTHENTICATED_REMEMBERED') &&
            $user->getId() == $this->getUser()->getId()) {
            return $this->redirect($this->generateUrl('profile_my_show'));
        }

        $contributorsArray = $this->get('geekhub.user_bundle.user_manager')->getContributedDreams($user, false);

        return $this->render('UserBundle:Profile:showStranger.html.twig', array(
            'user'              => $user,
            'contributorsArray' => $contributorsArray,
        ));
    }
}
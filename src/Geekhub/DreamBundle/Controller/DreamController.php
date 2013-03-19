<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\DreamBundle\Form\DreamType;
use Geekhub\DreamBundle\Entity\ProgressBar;

/**
 * Dream controller.
 *
 */
class DreamController extends Controller
{
    /**
     * Lists all Dream entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $dreams = $em->getRepository('DreamBundle:Dream')->findAll();

        //Set tags
        $tagManager = $this->get('fpn_tag.tag_manager');
        foreach ($dreams as $dream) {
            $tagManager->loadTagging($dream);
        }

        return $this->render('DreamBundle:Dream:index.html.twig', array(
            'dreams' => $dreams,
        ));
    }

    /**
     * Finds and displays a Dream entity.
     *
     */
    public function showAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $dream Dream */
        $dream = $em->getRepository('DreamBundle:Dream')->findOneBySlug($slug);

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
        }

        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($dream);

        $deleteForm = $this->createDeleteForm($slug);

        $contributorsArray = $this->get('geekhub.dream_bundle.dream_manager')->getContributorsArray($dream);

        return $this->render('DreamBundle:Dream:show.html.twig', array(
            'dream'                 => $dream,
            'delete_form'           => $deleteForm->createView(),
            'contributorsArray'     => $contributorsArray,
        ));
    }

    /**
     * Displays a form to create a new Dream entity.
     *
     */
    public function newAction()
    {
        $dream = new Dream();
        $tags = $this->getDoctrine()->getRepository('TagBundle:Tag')->findAll();
        $form   = $this->createForm(new DreamType(), $dream);

        return $this->render('DreamBundle:Dream:new.html.twig', array(
            'dream' => $dream,
            'tags' => $tags,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a new Dream entity.
     *
     */
    public function createAction(Request $request)
    {
        $securityContext = $this->container->get('security.context');
        if( !$securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED') ){
            throw new AccessDeniedException('Only authenticated user can create a dream');
        }

        $dream  = new Dream();

        $user= $this->get('security.context')->getToken()->getUser();
        $dream->setOwner($user);
        $form = $this->createForm(new DreamType(), $dream);
        $form->bind($request);

        if ($form->isValid()) {
            //Set Tags
            $tagManager = $this->get('fpn_tag.tag_manager');
            foreach ($dream->getTagArray() as $tag) {
                $oTag = $tagManager->loadOrCreateTag($tag);
                $tagManager->addTag($oTag, $dream);
            }

            //ProgressBar
            $progressBar = new ProgressBar();
            $progressBar->setEquipment(0);
            $progressBar->setFinance(0);
            $progressBar->setWork(0);
            $dream->setProgressBar($progressBar);

            $em = $this->getDoctrine()->getManager();
            $em->persist($progressBar);
            $em->persist($dream);
            $em->flush();

            $tagManager->saveTagging($dream);

            $message = \Swift_Message::newInstance()
                ->setSubject('Створена нова мрія '.$dream->getTitle())
                ->setFrom('noreplay@chedream.com')
                ->setTo('noreplay@chedream.com')
                ->setBody(
                $this->renderView(
                    'DreamBundle:Email:dreamNew.html.twig',
                    array(
                        'dream'     => $dream,
                        'user'      => $user,
                    )
                )
            )
            ;
            $this->get('mailer')->send($message);

            return $this->redirect($this->generateUrl('dream_show', array('slug' => $dream->getSlug())));
        }

        return $this->render('DreamBundle:Dream:new.html.twig', array(
            'dream' => $dream,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Dream entity.
     *
     */
    public function editAction($slug)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneBySlug($slug);
        $user= $this->get('security.context')->getToken()->getUser();

        $tags = $this->getDoctrine()->getRepository('TagBundle:Tag')->findAll();

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
        }
        elseif ($user->getUsernameCanonical() != $dream->getOwner()->getUsernameCanonical()) {
            throw new AccessDeniedException('Edit this dream can only it owner');
        }

        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($dream);

        $editForm = $this->createForm(new DreamType(), $dream);
        $deleteForm = $this->createDeleteForm($slug);

        return $this->render('DreamBundle:Dream:edit.html.twig', array(
            'dream'      => $dream,
            'tags'        => $tags,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Edits an existing Dream entity.
     *
     */
    public function updateAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();

        $dream = $em->getRepository('DreamBundle:Dream')->findOneBySlug($slug);
        $user= $this->get('security.context')->getToken()->getUser();

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
        }
        elseif ($user->getUsernameCanonical() != $dream->getOwner()->getUsernameCanonical()) {
            throw  new AccessDeniedException('Edit this dream can only it owner');
        }

        $deleteForm = $this->createDeleteForm($slug);
        $editForm = $this->createForm(new DreamType(), $dream);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            //Set Tags
            $tagManager = $this->get('fpn_tag.tag_manager');
            foreach ($dream->getTagArray() as $tag) {
                $oTag = $tagManager->loadOrCreateTag($tag);
                $oTags[] = $oTag;
            }
            $tagManager->replaceTags($oTags, $dream);

            $em->persist($dream);
            $em->flush();

            //Save tags
            $tagManager->saveTagging($dream);

            return $this->redirect($this->generateUrl('dream_show', array('slug' => $slug)));
        }

        return $this->render('DreamBundle:Dream:edit.html.twig', array(
            'dream'      => $dream,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a Dream entity.
     *
     */
    public function deleteAction(Request $request, $slug)
    {
        $form = $this->createDeleteForm($slug);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $dream = $em->getRepository('DreamBundle:Dream')->findOneBy($slug);
            $user= $this->get('security.context')->getToken()->getUser();

            if (!$dream) {
                throw $this->createNotFoundException('Unable to find Dream entity.');
            }
            elseif ($user->getUsernameCanonical() != $dream->getOwner()->getUsernameCanonical()) {
                throw  new AccessDeniedException('Edit this dream can only it owner');
            }

            $em->remove($dream);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('dream'));
    }

    private function createDeleteForm($slug)
    {
        return $this->createFormBuilder(array('slug' => $slug))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    public function getAjaxDreamShareCountAction($dreamId)
    {
        $em = $this->getDoctrine()->getManager();

        /** @var $dream Dream */
        $dream = $em->getRepository('DreamBundle:Dream')->findOneById($dreamId);

        if (!$dream) {
            $error = array('error' => 'Unable to find Dream entity');
            $jsonError = $this->container->get('serializer')->serialize($error, 'json');
            $response = new Response($jsonError);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        elseif (false == $this->getRequest()->isXmlHttpRequest())
        {
            $error = array('error' => 'Only ajax request can be send');
            $jsonError = $this->container->get('serializer')->serialize($error, 'json');
            $response = new Response($jsonError);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        $url = $this->generateUrl(
            'dream_show',
            array('slug' => $dream->getSlug()),
            true
        );
        $dreamShareCount = $this->get('geekhub.dream_bundle.like_manager')->getDreamShareCount($url);

        if ($dreamShareCount !== $dream->getLike()) {
            $dream->setLike($dreamShareCount);

            $em->persist($dream);
            $em->flush();
        }

        $response = $this->container->get('serializer')->serialize($dream->getLike(), 'json');

        return new Response($response);
    }
}

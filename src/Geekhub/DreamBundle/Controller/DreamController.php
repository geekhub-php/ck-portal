<?php

namespace Geekhub\DreamBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\DreamBundle\Form\DreamType;

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

        $dream = $em->getRepository('DreamBundle:Dream')->findOneBySlug($slug);

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
        }

        $tagManager = $this->get('fpn_tag.tag_manager');
        $tagManager->loadTagging($dream);

        $deleteForm = $this->createDeleteForm($slug);

        return $this->render('DreamBundle:Dream:show.html.twig', array(
            'dream'      => $dream,
            'delete_form' => $deleteForm->createView(),
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

            $em = $this->getDoctrine()->getManager();
            $em->persist($dream);
            $em->flush();

            $tagManager->saveTagging($dream);

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
        $tags = $this->getDoctrine()->getRepository('TagBundle:Tag')->findAll();

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
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

        if (!$dream) {
            throw $this->createNotFoundException('Unable to find Dream entity.');
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

            if (!$dream) {
                throw $this->createNotFoundException('Unable to find Dream entity.');
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
}

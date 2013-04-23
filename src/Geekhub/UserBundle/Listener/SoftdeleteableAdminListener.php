<?php

namespace Geekhub\UserBundle\Listener;

use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Doctrine\ORM\EntityManager;

class SoftdeleteableAdminListener
{
    private $disallow = array(
        'Sonata\AdminBundle\Controller\CRUDController::editAction'
    );

    /** @var EntityManager */
    private $em;

    public function disableSoftdeleteable(FilterControllerEvent $event)
    {
        $request = $event->getRequest();
        $controllerName = $request->attributes->get('_controller');

        if (in_array($controllerName, $this->disallow)) {
            $this->em->getFilters()->disable('softdeleteable');
        }
    }

    public function setEntityManager(EntityManager $em)
    {
        $this->em = $em;
    }
}
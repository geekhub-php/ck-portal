<?php

namespace Geekhub\UserBundle\Listener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\EntityManager;
use Geekhub\UserBundle\Entity\User;
use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\DreamBundle\Entity\AbstractPoint;

class UserLockedListener
{
    /** @var EntityManager */
    private $em;

    /** @var UnitOfWork */
    private $uow;

    public function preUpdate(PreUpdateEventArgs $args)
    {
        /** @var $user User */
        $user = $args->getEntity();
        $this->em = $args->getEntityManager();
        $this->uow = $this->em->getUnitOfWork();

        if ($user instanceof User
            && $args->hasChangedField('locked')
            && $args->getOldValue('locked') == false
            && $args->getNewValue('locked') == true)
        {
            foreach ($user->getUserDreams() as $dream) {
                $this->closeDreamIfItOpen($dream);
            }

            $user->setLockedAt(new \DateTime());
            $this->deleteDonates($user->getEquipmentDonates());
            $this->deleteDonates($user->getFinancialDonates());
            $this->deleteDonates($user->getWorkDonates());
            $this->deleteDonates($user->getOtherDonates());

            $this->uow->recomputeSingleEntityChangeSet(
                $this->em->getClassMetadata("UserBundle:User"),
                $user
            );
        }
    }

    private function closeDreamIfItOpen(Dream $dream)
    {
        if (!$dream->getLocked() && $dream->getState() == 'open') {
            $this->deleteDonates($dream->getEquipment());
            $this->deleteDonates($dream->getFinancial());
            $this->deleteDonates($dream->getWork());
            $this->deleteDonates($dream->getOtherDonate());

            $this->uow->scheduleExtraUpdate($dream, array(
                'locked' => array(false, true),
                'state' => array('open', 'close'),
            ));
        }
    }

    private function deleteDonates($points)
    {
        /** @var $point AbstractPoint */
        foreach ($points as $point) {
            if ($point->getIsDonate() && $point->getDream()->getState() == 'open') {
                $this->uow->scheduleExtraUpdate($point, array(
                    'deletedAt' => array($point->getDeletedAt(), new \DateTime()),
                    'locked' => array(false, true),
                ));
            }
        }
    }
}

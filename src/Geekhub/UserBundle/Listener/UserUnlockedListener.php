<?php

namespace Geekhub\UserBundle\Listener;

use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\UnitOfWork;
use Doctrine\ORM\EntityManager;
use Geekhub\UserBundle\Entity\User;
use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\DreamBundle\Entity\AbstractPoint;

class UserUnlockedListener
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
            && $args->getOldValue('locked') == true
            && $args->getNewValue('locked') == false)
        {
            foreach ($user->getUserDreams() as $dream) {
                $this->openDreamIfItClosed($dream, $user);
            }

            $user->setLockedAt(new \DateTime());
            $this->undeleteDonates($user->getEquipmentDonates());
            $this->undeleteDonates($user->getFinancialDonates());
            $this->undeleteDonates($user->getWorkDonates());
            $this->undeleteDonates($user->getOtherDonates());
            $this->uow->recomputeSingleEntityChangeSet(
                $this->em->getClassMetadata("UserBundle:User"),
                $user
            );
        }
    }

    private function openDreamIfItClosed(Dream $dream, User $user)
    {
        if ($dream->getLocked() && $dream->getState() == 'close') {
            echo $dream->getId();
            $this->undeleteDonates($dream->getEquipment());
            $this->undeleteDonates($dream->getFinancial());
            $this->undeleteDonates($dream->getWork());
            $this->undeleteDonates($dream->getOtherDonate());

            $this->uow->scheduleExtraUpdate($dream, array(
                'locked' => array(true, false),
                'state' => array('close', 'open')
            ));
        }
    }

    private function undeleteDonates($points)
    {
        /** @var $point AbstractPoint */
        foreach ($points as $point) {
            if ($point->getIsDonate() && $point->getLocked()) {
                $this->uow->scheduleExtraUpdate($point, array(
                    'deletedAt' => array($point->getDeletedAt(), NULL),
                    'locked' => array(true, false),
                ));
            }
        }
    }
}

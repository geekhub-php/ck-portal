<?php

namespace Geekhub\DreamBundle;

use Symfony\Component\Security\Core\SecurityContext;

use Geekhub\DreamBundle\Entity\AbstractPoint;
use Geekhub\UserBundle\Entity\User;
use Geekhub\DreamBundle\Entity\Dream;

class DreamManager
{
    private $currentUser;

    private $context;

    public function __construct(SecurityContext $context)
    {
        $this->currentUser = $context->getToken()->getUser();
        $this->context = $context;
    }

    public function getContributorsArray(Dream $dream)
    {
        $contributions = array_merge(
            $dream->getFinancial()->toArray(),
            $dream->getEquipment()->toArray(),
            $dream->getWork()->toArray(),
            $dream->getOtherDonate()->toArray()
        );
        $contributorsArray = array();

        /** @var $item AbstractPoint */
        foreach ($contributions as $item) {
            /** @var $user User */
            $user = $item->getUser();

            if ($user == NULL) {
                continue;
            }
            elseif ($item->getHide() && !$this->context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                continue;
            }
            elseif ($item->getHide()
                && $user->getId() != $dream->getOwner()->getId()
                && $user->getId() != $this->currentUser->getId()) {
                continue;
            }

            $contributorsArray[$user->getId()] = array('user' => $user, 'contributions' => array());
        }

        /** @var $item AbstractPoint */
        foreach ($contributions as $item) {
            /** @var $user User */
            $user = $item->getUser();

            if ($user == NULL) {
                continue;
            }
            elseif ($item->getHide() && !$this->context->isGranted('IS_AUTHENTICATED_REMEMBERED')) {
                continue;
            }
            elseif ($item->getHide()
                && $user->getId() != $dream->getOwner()->getId()
                && $user->getId() != $this->currentUser->getId()) {
                continue;
            }

            $contributorsArray[$user->getId()]['contributions'][] = $item;
        }

        return $contributorsArray;
    }

    public function getNewProgressBar(Dream $dream)
    {
        $planQuantity = 0;
        $partPlan = 0;
        $progressBar = $dream->getProgressBar();

        //Set finance
        foreach ($dream->getFinancial() as $financialPoint) {
            if ($financialPoint->getIsDonate() == false) {
                $planQuantity = $planQuantity + $financialPoint->getQuantity();
            }
            else {
                $partPlan = $partPlan + $financialPoint->getQuantity();
            }
        }

        $progressBar->setFinance(round(($partPlan/$planQuantity), 2));

        //Set equipment
        $planQuantity = 0;
        $partPlan = 0;
        foreach ($dream->getEquipment() as $equipmentPoint) {
            if ($equipmentPoint->getIsDonate() == false) {
                $planQuantity = $planQuantity + $equipmentPoint->getQuantity();
            }
            else {
                $partPlan = $partPlan + $equipmentPoint->getQuantity();
            }
        }

        $progressBar->setEquipment(round(($partPlan/$planQuantity), 2));

        //Set work
        $planQuantity = 0;
        $partPlan = 0;
        foreach ($dream->getWork() as $workPoint) {
            if ($workPoint->getIsDonate() == false) {
                $planQuantity = $planQuantity + $workPoint->getQuantity();
            }
            else {
                $partPlan = $partPlan + $workPoint->getQuantity();
            }
        }

        $progressBar->setWork(round(($partPlan/$planQuantity), 2));

        return $progressBar;
    }
}
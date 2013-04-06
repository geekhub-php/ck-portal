<?php

namespace Geekhub\UserBundle;

use Geekhub\UserBundle\Entity\User;
use Geekhub\DreamBundle\Entity\AbstractPoint;

class UserManager
{
    public function getContributedDreams(User $user, $profileOwner)
    {
        $contributions = array_merge(
            $user->getEquipmentDonates()->toArray(),
            $user->getFinancialDonates()->toArray(),
            $user->getWorkDonates()->toArray(),
            $user->getOtherDonates()->toArray()
        );

        $contributorsArray = array();

        /** @var $item AbstractPoint */
        foreach ($contributions as $item) {
            if (!$item->getIsDonate()) {
                continue;
            }
            elseif ($item->getHide() && !$profileOwner) {
                continue;
            }

            $contributorsArray[$item->getDream()->getId()] = array('dream' => $item->getDream(), 'contributions' => array());
        }

        /** @var $item AbstractPoint */
        foreach ($contributions as $item) {
            if (!$item->getIsDonate()) {
                continue;
            }
            elseif ($item->getHide() && !$profileOwner) {
                continue;
            }

            $contributorsArray[$item->getDream()->getId()]['contributions'][] = $item;
        }

        return $contributorsArray;
    }
}
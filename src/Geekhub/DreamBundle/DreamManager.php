<?php

namespace Geekhub\DreamBundle;

use Geekhub\DreamBundle\Entity\ContributorSupport;
use Geekhub\UserBundle\Entity\User;

class DreamManager
{
    public function getContributorsArray($contributions)
    {
        $contributorsArray = array();

        /** @var $item ContributorSupport */
        foreach ($contributions as $item) {
            /** @var $user User */
            $user = $item->getUser();
            $contributorsArray[$user->getId()] = array('user' => $user, 'contributions' => array());
        }

        /** @var $item ContributorSupport */
        foreach ($contributions as $item) {
            /** @var $user User */
            $user = $item->getUser();
            $contributorsArray[$user->getId()]['contributions'][] = $item;
        }

        return $contributorsArray;
    }
}
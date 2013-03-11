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

//        foreach ($contributorsArray as $contribution) {
//            echo $contribution['user']->getName();
//
//            foreach ($contribution['contributions'] as $item) {
//                echo get_class($item->getContributeItem());
//                echo $item->getContributeItem()->getName().' - '.$item->getContributeItem()->getQuantity().'<br />';
//            }
//        }
//        exit;
        return $contributorsArray;
    }
}
<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * DreamRepository
 */
class DreamRepository extends EntityRepository
{
    public function getCountDreams($state)
    {
        $qb = $this->createQueryBuilder('d');

        switch ($state) {
            case 'success':
                $qb->Where('d.state = :state')
                    ->setParameter('state', $state);
                break;
            case 'complete':
                $qb->Where('d.state = :state')
                    ->setParameter('state', $state);
                break;
        }

        return count($qb->getQuery()->getArrayResult());
    }
}
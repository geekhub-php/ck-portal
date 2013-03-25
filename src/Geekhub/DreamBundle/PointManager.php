<?php

namespace Geekhub\DreamBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\SecurityContext;
use Doctrine\ORM\EntityRepository;

use Geekhub\DreamBundle\Entity\Financial;
use Geekhub\DreamBundle\Entity\Equipment;
use Geekhub\DreamBundle\Entity\Work;
use Geekhub\DreamBundle\Entity\OtherDonate;
use Geekhub\DreamBundle\Entity\Dream;

class PointManager
{
    private $context;

    /** @var \Doctrine\ORM\EntityRepository */
    private $financialRepo;

    /** @var \Doctrine\ORM\EntityRepository */
    private $equipmentRepo;

    /** @var \Doctrine\ORM\EntityRepository */
    private $workRepo;

    /** @var \Doctrine\ORM\EntityRepository */
    private $otherDonateRepo;

    public function __construct(SecurityContext $context,
                                EntityRepository $financialRepo,
                                EntityRepository $equipmentRepo,
                                EntityRepository $workRepo,
                                EntityRepository $otherDonateRepo
    )
    {
        $this->context = $context;
        $this->financialRepo = $financialRepo;
        $this->equipmentRepo = $equipmentRepo;
        $this->workRepo = $workRepo;
        $this->otherDonateRepo = $otherDonateRepo;
    }

    public function getPointEntityFromRequest(Request $request, Dream $dream)
    {
        $entityName = $request->get('entity');

        switch ($entityName) {
            case 'financial':
                $points = $this->getFinancialFromRequest($request, $dream);
                break;
            case 'equipment':
                $points = $this->getEquipmentFromRequest($request, $dream);
                break;
            case 'work':
                $points = $this->getWorkFromRequest($request, $dream);
                break;
            case 'other':
                $points = $this->getOtherDonateFromRequest($request, $dream);
                break;
            default:
                return new Response(array('error' => 'No entity found'));
        }

        return $points;
    }

    protected function getFinancialFromRequest($request, $dream)
    {
        $request->get('hide') == 'true' ? $hide = 1 : $hide = 0;
        $point = $this->financialRepo->findOneBy(array(
            'dream' => $dream,
            'user' => $this->getUser(),
            'isDonate' => true,
            'hide' => $hide
        ));

        if ($point) {
            $point->setQuantity($point->getQuantity() + $request->get('quantity'));
            return array($point);
        }


        $point = new Financial();
        $parentPoint = $this->financialRepo->findOneByDream($dream);

        $point->setQuantity($request->get('quantity'));
        $point->setName('');
        $point->setDream($dream);
        $point->setParent($parentPoint);
        $point->setUser($this->getUser());
        $point->setHide($hide);
        $point->setIsDonate(1);

        return array($point);
    }

    protected function getEquipmentFromRequest($request, $dream)
    {
        $points = array();

        foreach ($request->get('equipment') as $id => $quantity) {
            if ($quantity == 0) {
                continue;
            }

            $request->get('hide') == 'true' ? $hide = 1 : $hide = 0;

            /** @var $parentPoint Equipment */
            $parentPoint = $this->equipmentRepo->findOneById($id);
            $point = $this->equipmentRepo->findOneBy(array(
                'parent' => $parentPoint,
                'user' => $this->getUser(),
                'isDonate' => true,
                'hide' => $hide
            ));

            if ($point) {
                $point->setQuantity($point->getQuantity() + $quantity);
            }
            else {
                $point = new Equipment();

                $point->setName($parentPoint->getName());
                $point->setQuantity($quantity);
                $point->setDream($dream);
                $point->setParent($parentPoint);
                $point->setUser($this->getUser());
                $point->setHide($hide);
                $point->setIsDonate(1);
            }

            $points[] = $point;
        }

        return $points;
    }

    protected function getWorkFromRequest($request, $dream)
    {
        $points = array();

        foreach ($request->get('work') as $id => $quantity) {
            $quantity == 'true' ? $quantity = 1 : $quantity = 0;

            if ($quantity == 0) {
                continue;
            }

            $request->get('hide') == 'true' ? $hide = 1 : $hide = 0;

            /** @var $parentPoint Work */
            $parentPoint = $this->workRepo->findOneById($id);
            $point = $this->workRepo->findOneBy(array(
                'parent' => $parentPoint,
                'user' => $this->getUser(),
                'isDonate' => true,
            ));

            if ($point) {
                $point->setQuantity($quantity);
            }
            else {
                $point = new Work();

                $point->setName($parentPoint->getName());
                $point->setQuantity(1);
                $point->setDream($dream);
                $point->setParent($parentPoint);
                $point->setUser($this->getUser());
                $point->setHide($hide);
                $point->setIsDonate(1);
            }

            $points[] = $point;
        }

        return $points;
    }

    protected function getOtherDonateFromRequest($request, $dream)
    {
        $request->get('hide') == 'true' ? $hide = 1 : $hide = 0;

        $point = new OtherDonate();

        $point->setQuantity(1);
        $point->setName($request->get('quantity'));
        $point->setDream($dream);
        $point->setUser($this->getUser());
        $point->setHide($hide);
        $point->setIsDonate(1);

        return array($point);
    }

    protected function getUser()
    {
        return $this->context->getToken()->getUser();
    }
}
<?php

namespace Geekhub\DreamBundle;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

use Geekhub\DreamBundle\Entity\Financial;
use Geekhub\DreamBundle\Entity\Equipment;
use Geekhub\DreamBundle\Entity\Work;
use Geekhub\DreamBundle\Entity\Dream;

class PointManager
{
    public function getPointEntityFromRequest(Request $request, Dream $dream)
    {
        $entityName = $request->get('entity');

        switch ($entityName) {
            case 'financial':
                $point = $this->getFinancialFromRequest($request, $dream);
                break;
            case 'equipment':
                $point = $this->getEquipmentFromRequest($request, $dream);
                break;
            case 'work':
                $point = $this->getWorkFromRequest($request, $dream);
                break;
            case 'other':
                $point = $this->getOtherDonateFromRequest($request, $dream);
                break;
            default:
                return new Response(array('error' => 'No entity found'));
        }

        return $point;
    }

    protected function getFinancialFromRequest($request, $dream)
    {
        $point = new Financial();

        $point->setQuantity($request->get('quantity'));
        $point->setName('');
        $point->getDream($dream);

        return $point;
    }

    protected function getEquipmentFromRequest($request, $dream)
    {
        foreach ($request->get('equipment') as $id => $value) {
        }

        return 'equipment';
    }

    protected function getWorkFromRequest($request, $dream)
    {
        return 'work';
    }

    protected function getOtherDonateFromRequest($request, $dream)
    {
        return 'other_donate';
    }
}
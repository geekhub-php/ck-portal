<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\ContributorSupport;

class LoadContributionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $currentDream = 'dream' . rand(0, 29);

            $dream = $this->getReference($currentDream);
            $getWorkDreamPoints = $this->getReference($currentDream)->getWork();
            $getFinancialDreamPoints = $this->getReference($currentDream)->getFinancial();
            $getEquipmentDreamPoints = $this->getReference($currentDream)->getEquipment();

            if ($getWorkDreamPoints) {
                foreach ($getWorkDreamPoints as $workPoint) {
//                    $id = $workPoint->getId();
//                    $workArray[$id]['job'] = $workPoint->getJob();
//                    $workArray[$id]['employee'] = $workPoint->getEmployee();
//                    $workArray[$id]['days'] = $workPoint->getDay();
                    $workObjArray[] = $workPoint;
                }

                $l = count($workObjArray);
                $obj = $workObjArray[rand(0, $l - 1)];

                if ($obj && $obj->getJob()) {
                    $workContributionPoint = new \Geekhub\DreamBundle\Entity\Work();
                    $workContributionPoint->setJob($obj->getJob());
                    $workContributionPoint->setEmployee(rand(1,3));
                    $workContributionPoint->setDay(rand(1,3));
                    $workContributionPoint->setDream($dream);
                }

                $workObjArray = null;
            }

            if ($getFinancialDreamPoints) {
                foreach ($getFinancialDreamPoints as $financialPoint) {
//                    $id = $financialPoint->getId();
//                    $financialArray[$id]['id'] = $financialPoint->getId();
//                    $financialArray[$id]['item'] = $financialPoint->getItem();
//                    $financialArray[$id]['total'] = $financialPoint->getTotal();
                    $financialObjArray[] = $financialPoint;
                }

                $l = count($financialObjArray);
                $obj = $financialObjArray[rand(0, $l - 1)];

                if ($obj && $obj->getItem()) {
                    $financialContributionPoint = new \Geekhub\DreamBundle\Entity\Financial();
                    $financialContributionPoint->setItem($obj->getItem());
                    $financialContributionPoint->setTotal(rand(12345,256456));
                    $financialContributionPoint->setDream($dream);
                }

                $financialObjArray = null;
            }

            if ($getEquipmentDreamPoints) {
                foreach ($getEquipmentDreamPoints as $equipmentPoint) {
//                    $id = $equipmentPoint->getId();
//                    $equipmentArray[$id]['item'] = $equipmentPoint->getItem();
//                    $equipmentArray[$id]['unit'] = $equipmentPoint->getUnit();
//                    $equipmentArray[$id]['total'] = $equipmentPoint->getTotal();
                    $equipmentObjArray[] = $equipmentPoint;
                }

                $l = count($equipmentObjArray);
                $obj = $equipmentObjArray[rand(0, $l - 1)];

                if ($obj && $obj->getItem()) {
                    $equipmentContributionPoint = new \Geekhub\DreamBundle\Entity\Equipment();
                    $equipmentContributionPoint->setItem($obj->getItem());
                    $equipmentContributionPoint->setUnit($obj->getUnit());
                    $equipmentContributionPoint->setTotal(rand(1,3));
                    $equipmentContributionPoint->setDream($dream);
                }

                $equipmentObjArray = null;
            }


            $user = $this->getReference('user' . rand(1, 17));

            $contribution = new ContributorSupport();
            $contribution->addFinancial($financialContributionPoint->setContribution($contribution));
            $contribution->addEquipment($equipmentContributionPoint->setContribution($contribution));
            $contribution->addWork($workContributionPoint->setContribution($contribution));
            $contribution->setHide(rand(0, 1));
            $contribution->setUser($user);
            $contribution->setDream($dream);

            $manager->persist($contribution);
            $manager->flush();

        }
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 32;
    }


}
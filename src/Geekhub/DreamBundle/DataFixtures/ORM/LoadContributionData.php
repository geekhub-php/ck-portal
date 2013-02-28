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
                    $id = $workPoint->getId();
                    $workArray[$id]['job'] = $workPoint->getJob();
                    $workArray[$id]['employee'] = $workPoint->getEmployee();
                    $workArray[$id]['days'] = $workPoint->getDay();
                    $workIdArray[] = $id;
                }

                $l = count($workArray);

                $currentPointId = $workIdArray[rand(0, $l - 1)];
                $workContributionPoint = new \Geekhub\DreamBundle\Entity\Work();
                $workContributionPoint->setJob($workArray[$currentPointId]['job']);
                $workContributionPoint->setEmployee(1);
                $workContributionPoint->setDay(1);
                $workContributionPoint->setDream($dream);
            }

            if ($getFinancialDreamPoints) {
                foreach ($getFinancialDreamPoints as $financialPoint) {
                    $id = $financialPoint->getId();
                    $financialArray[$id]['id'] = $financialPoint->getId();
                    $financialArray[$id]['item'] = $financialPoint->getItem();
                    $financialArray[$id]['total'] = $financialPoint->getTotal();
                    $financialIdArray[] = $id;
                }

                $l = count($financialArray);

                $currentPointId = $financialIdArray[rand(0, $l - 1)];
                $financialContributionPoint = new \Geekhub\DreamBundle\Entity\Financial();
                $financialContributionPoint->setItem($financialArray[$currentPointId]['item']);
                $financialContributionPoint->setTotal(12300);
                $financialContributionPoint->setDream($dream);
            }

            if ($getEquipmentDreamPoints) {
                foreach ($getEquipmentDreamPoints as $equipmentPoint) {
                    $id = $equipmentPoint->getId();
                    $equipmentArray[$id]['item'] = $equipmentPoint->getItem();
                    $equipmentArray[$id]['unit'] = $equipmentPoint->getUnit();
                    $equipmentArray[$id]['total'] = $equipmentPoint->getTotal();
                    $equipmentIdArray[] = $id;
                }
                
                $l = count($equipmentIdArray);

                $currentPointId = $equipmentIdArray[rand(0, $l - 1)];
                $equipmentContributionPoint = new \Geekhub\DreamBundle\Entity\Equipment();
                $equipmentContributionPoint->setItem($equipmentArray[$currentPointId]['item']);
                $equipmentContributionPoint->setUnit($equipmentArray[$currentPointId]['unit']);
                $equipmentContributionPoint->setTotal(1);
                $equipmentContributionPoint->setDream($dream);
            }


            $user = $this->getReference('user' . rand(1, 17));

            $contribution = new ContributorSupport();
            $contribution->setDream($dream);
            $contribution->setPoint($financialContributionPoint)->setPoint($equipmentContributionPoint)->setPoint($workContributionPoint);
            $contribution->setHide(rand(0, 1));
            $contribution->setUser($user);

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
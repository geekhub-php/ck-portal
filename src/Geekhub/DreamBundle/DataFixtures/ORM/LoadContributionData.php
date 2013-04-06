<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Dream;
use Geekhub\DreamBundle\Entity\Work;
use Geekhub\DreamBundle\Entity\Financial;
use Geekhub\DreamBundle\Entity\Equipment;

class LoadContributionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $currentDream = 'dream' . rand(0, 29);

            /** @var $dream Dream */
            $dream = $this->getReference($currentDream);
            $workDreamPoints = $dream->getWork();
            $financialDreamPoints = $dream->getFinancial();
            $equipmentDreamPoints = $dream->getEquipment();

            if ($workDreamPoints) {
                //get 100%
                $planQuantity = 0;
                foreach ($workDreamPoints as $workPoint) {
                    $planQuantity = $planQuantity + $workPoint->getQuantity();
                }
                /** @var $workPoint Work */
                foreach ($workDreamPoints as $workPoint) {
                    $user = $this->getReference('user' . rand(1, 17));

                    if (rand(1, 3) == 2) {
                        continue;
                    }
                    elseif ($user->getId() == $dream->getOwner()->getId()) {
                        continue;
                    }

                    $work = new Work();

                    $work->setQuantity(1);
                    $work->setName($workPoint->getName());
                    $work->setDream($dream);
                    $work->setHide(rand(0, 1));
                    $work->setUser($user);
                    $work->setParent($workPoint);
                    $work->setIsDonate(true);

                    $partPlan = $work->getQuantity()/$planQuantity;
                    $progressBar = $dream->getProgressBar();
                    $progressBar->addWork($partPlan);

                    $manager->persist($progressBar);
                    $manager->persist($work);
                    $manager->flush();
                }
            }

            if ($financialDreamPoints) {
                //get 100%
                $planQuantity = 0;
                foreach ($financialDreamPoints as $financialPoint) {
                    $planQuantity = $planQuantity + $financialPoint->getQuantity();
                }
                /** @var $financialPoint Financial */
                foreach ($financialDreamPoints as $financialPoint) {
                    $user = $this->getReference('user' . rand(1, 17));

                    if (rand(1, 3) == 2) {
                        continue;
                    }
                    elseif ($user->getId() == $dream->getOwner()->getId()) {
                        continue;
                    }

                    $financial = new Financial();

                    $financial->setName($financialPoint->getName());
                    $financial->setQuantity(rand(10, $planQuantity/4));
                    $financial->setDream($dream);
                    $financial->setHide(rand(0, 1));
                    $financial->setUser($user);
                    $financial->setParent($financialPoint);
                    $financial->setIsDonate(true);

                    $partPlan = $financial->getQuantity()/$planQuantity;
                    $progressBar = $dream->getProgressBar();
                    $progressBar->addFinance($partPlan);

                    $manager->persist($progressBar);
                    $manager->persist($financial);
                    $manager->flush();
                }
            }

            if ($equipmentDreamPoints) {
                //get 100%
                $planQuantity = 0;
                foreach ($equipmentDreamPoints as $equipmentPoint) {
                    $planQuantity = $planQuantity + $equipmentPoint->getQuantity();
                }
                /** @var $equipmentPoint Equipment */
                foreach ($equipmentDreamPoints as $equipmentPoint) {
                    $user = $this->getReference('user' . rand(1, 17));

                    if (rand(1, 3) == 2) {
                        continue;
                    }
                    elseif ($user->getId() == $dream->getOwner()->getId()) {
                        continue;
                    }

                    $equipment = new Equipment();

                    $equipment->setDream($dream);
                    $equipment->setName($equipmentPoint->getName());
                    $equipment->setQuantity(rand(1, $planQuantity/5));
                    $equipment->setHide(rand(0, 1));
                    $equipment->setUser($user);
                    $equipment->setParent($equipmentPoint);
                    $equipment->setIsDonate(true);

                    $partPlan = $equipment->getQuantity()/$planQuantity;
                    $progressBar = $dream->getProgressBar();
                    $progressBar->addEquipment($partPlan);

                    $manager->persist($progressBar);
                    $manager->persist($equipment);
                    $manager->flush();
                }
            }
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
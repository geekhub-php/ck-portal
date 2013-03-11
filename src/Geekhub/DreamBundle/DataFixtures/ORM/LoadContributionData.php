<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\ContributorSupport;
use Geekhub\DreamBundle\Entity\Work;
use Geekhub\DreamBundle\Entity\Financial;
use Geekhub\DreamBundle\Entity\Equipment;

class LoadContributionData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $currentDream = 'dream' . rand(0, 29);

            $dream = $this->getReference($currentDream);
            $workDreamPoints = $dream->getWork();
            $financialDreamPoints = $dream->getFinancial();
            $equipmentDreamPoints = $dream->getEquipment();

            if ($workDreamPoints) {
                /** @var $workPoint Work */
                foreach ($workDreamPoints as $workPoint) {
                    if (rand(1, 2) == 2) {
                        continue;
                    }
                    $user = $this->getReference('user' . rand(1, 17));
                    $contribution = new ContributorSupport();
                    $work = new Work();

                    $work->setQuantity(rand(1, 5));
                    $work->setWorker(1);
                    $work->setName($workPoint->getName());
                    $work->setDream($dream);

                    $contribution->setHide(rand(0, 1));
                    $contribution->setUser($user);
                    $contribution->setDream($dream);
                    $contribution->setContributeItem($work);

                    $manager->persist($contribution);
                    $manager->flush();
                }
            }

            if ($financialDreamPoints) {
                /** @var $financialPoint Financial */
                foreach ($financialDreamPoints as $financialPoint) {
                    if (rand(1, 2) == 2) {
                        continue;
                    }
                    $user = $this->getReference('user' . rand(1, 17));
                    $contribution = new ContributorSupport();
                    $financial = new Financial();

                    $financial->setName($financialPoint->getName());
                    $financial->setQuantity(rand(250, 1250000));
                    $financial->setDream($dream);

                    $contribution->setHide(rand(0, 1));
                    $contribution->setUser($user);
                    $contribution->setDream($dream);
                    $contribution->setContributeItem($financial);

                    $manager->persist($contribution);
                    $manager->flush();
                }
            }

            if ($equipmentDreamPoints) {
                /** @var $equipmentPoint Equipment */
                foreach ($equipmentDreamPoints as $equipmentPoint) {
                    if (rand(1, 2) == 2) {
                        continue;
                    }
                    $user = $this->getReference('user' . rand(1, 17));
                    $contribution = new ContributorSupport();
                    $equipment = new Equipment();

                    $equipment->setDream($dream);
                    $equipment->setName($equipmentPoint->getName());
                    $equipment->setQuantity(rand(1, 25));

                    $contribution->setHide(rand(0, 1));
                    $contribution->setUser($user);
                    $contribution->setDream($dream);
                    $contribution->setContributeItem($equipment);

                    $manager->persist($contribution);
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
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
        $point = array('work', 'financial', 'equipment');

        for ($i = 0; $i < 100; $i++) {
            $contribution = new ContributorSupport();
            $contribution->setDream($this->getReference('dream'.rand(0,29)));
            $contribution->setPoint($this->getReference($point[rand(0,2)].$i));
            $contribution->setHide(rand(0,1));
            $contribution->setUser($this->getReference('user'.rand(1,17)));

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
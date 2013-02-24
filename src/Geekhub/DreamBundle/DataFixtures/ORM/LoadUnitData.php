<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Unit;

class LoadUnitData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $units = array('кг', 'т', 'шт');
        $i = 1;

        foreach ($units as $unitName) {
            $unitRef = 'unit'.$i;

            $unit = new Unit();
            $unit->setName($unitName);

            $manager->persist($unit);
            $manager->flush();

            $this->addReference($unitRef, $unit);

            $i++;
        }

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 2;
    }


}
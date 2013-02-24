<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Equipment;

class LoadEquipmentData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i = 1;

        foreach ($this->getEquipmentList() as $equipmentItem){
            $equipmentRef = 'equipment'.$i;
            $equipment = new Equipment();
            $equipment->setDreamId(10);
            $equipment->setItem($equipmentItem);
            $equipment->setTotal(rand(1,25));
            $equipment->setUnit($this->getReference('unit'.rand(1,3)));

            $manager->persist($equipment);
            $manager->flush();

            $this->addReference($equipmentRef, $equipment);

            $i++;
        }
    }

    function getEquipmentList()
    {
        $i = 1;
        $equipmentFile = fopen(__DIR__ . "/equipment", "r");
        while (!feof($equipmentFile)) {
            $equipment = fgets($equipmentFile);
            $list[$i] = $equipment;
            $i++;
        }
        fclose($equipmentFile);

        return $list;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 5;
    }


}
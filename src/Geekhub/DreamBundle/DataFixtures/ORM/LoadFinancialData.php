<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Financial;

class LoadFinancialData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $i = 1;
        $item = array(
            1 => 'Затраты на построку',
            2 => 'Затраты на перевозку',
            3 => 'Затраты на доставку мусора на свалку',
            4 => 'Форс-мажор',
            5 => 'Другие затраты'
        );

        for ($i = 1; $i <= 200; $i++) {
            $financial = new Financial();
            $financial->setPoint($this->getReference('point' . rand(1, 30)));
            $financial->setItem($item[rand(1, 5)]);
            $financial->setTotal(rand(250, 1250000));

            $manager->persist($financial);
            $manager->flush();

            $this->setReference('financial'.$i, $financial);
        }

    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 22;
    }


}
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
            1 => 'Затраты на построкй',
            2 => 'Затраты на перевозку',
            3 => 'Затраты на доставку мусора на свалку',
            4 => 'Форс-мажор',
            5 => 'Другие затраты'
        );

        for ($i = 1; $i <= 5; $i++){
            $financialRef = 'financial'.$i;

            $financial = new Financial();
            $financial->setDreamId(10);
            $financial->setItem($item[$i]);
            $financial->setTotal(rand(250,1250000));

            $manager->persist($financial);
            $manager->flush();

            $this->addReference($financialRef, $financial);
        }

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
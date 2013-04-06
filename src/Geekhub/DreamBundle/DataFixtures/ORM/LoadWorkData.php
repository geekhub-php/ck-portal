<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Work;

class LoadWorkData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $job = $this->getJobList();

        for ($i = 0; $i < 100; $i++) {
            $work = new Work();
            $work->setQuantity(rand(1, 5));
            $work->setName($job[rand(1, 17)]);

            $manager->persist($work);
            $manager->flush();

            $this->setReference('work'.$i, $work);
        }
    }

    function getJobList()
    {
        $i = 1;
        $jobFile = fopen(__DIR__ . "/job", "r");
        while (!feof($jobFile)) {
            $job = fgets($jobFile);
            $list[$i] = $job;
            $i++;
        }
        fclose($jobFile);

        return $list;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 25;
    }


}
<?php
namespace Geekhub\PagesBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Behat\Gherkin\Node\TableNode;

use Geekhub\PagesBundle\Entity\Faq;

class LoadFaqData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $table = new TableNode(file_get_contents(__DIR__.'/faq.gherkin'));
        $array = $table->getRows();
        for ($i = 1; isset($array[$i]); $i++) {
            $entity = new Faq();
            for ($col = 0; isset($array[$i][$col]); $col++) {
                $setter = 'set'.ucfirst($array[0][$col]);
                $entity->$setter($array[$i][$col]);
            }

            $manager->persist($entity);
        }

        $manager->flush();
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 51;
    }

}
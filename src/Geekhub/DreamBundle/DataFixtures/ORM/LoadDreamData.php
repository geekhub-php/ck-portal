<?php
namespace Geekhub\DreamBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\DreamBundle\Entity\Dream;

class LoadDreamData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $date = $this->getCreatedAndDeletedAtAndUpdatedList();
        $info = $this->getTitleAndDescriptionList();
        $state = array('open', 'close', 'complete', 'success');
        $operator = array('050', '066', '063', '067');


        for ($i = 0; $i < 30; $i++) {
            $dream = new Dream();
            $dream->setTitle($info[rand(1,17)]['title']);
            $dream->setDescription($info[rand(1,17)]['description']);
            $dream->setCreated($date[rand(1,17)]['created']);
            $dream->setUpdated($date[rand(1,17)]['updated']);
            $dream->setDeletedAt($date[rand(1,17)]['deleted']);
            $dream->setOnFront(rand(0, 1));
            $dream->setOwner($this->getReference('user' . rand(1,17)));
            $dream->setPhone('+38(' . $operator[rand(0, 3)] . ')' . rand(100, 500) . '-' . rand(10, 99) . '-' . rand(10, 99));
            $dream->setPhoneAvailable(rand(1, 0));
            $dream->setState($state[rand(0, 3)]);

            for ($b = 3*$i; $b < 3*$i + 3; $b++) {
                $dream->addEquipment($this->getReference('equipment'.$b));
                $dream->addFinancial($this->getReference('financial'.$b));
                $dream->addWork($this->getReference('work'.$b));

                $this->getReference('equipment'.$b)->setDream($dream);
                $this->getReference('financial'.$b)->setDream($dream);
                $this->getReference('work'.$b)->setDream($dream);
            }

            $dream->addUsersWhoFavorite($this->getReference('user' . rand(1,5)));
            $dream->addUsersWhoFavorite($this->getReference('user' . rand(6,10)));
            $dream->addUsersWhoFavorite($this->getReference('user' . rand(11,15)));
            $dream->addUsersWhoFavorite($this->getReference('user' . rand(16,17)));



            $manager->persist($dream);
            $manager->flush();

            $this->addReference('dream' . $i, $dream);

        }
    }

    function getCreatedAndDeletedAtAndUpdatedList()
    {
        $list = array();

        for ($i = 1; $i <= 17; $i++) {
            $created = new \DateTime();
            $created->setDate(2012, rand(1, 4), rand(1, 28));
            $created->format('Y-m-d');
            $list[$i]['created'] = $created;

            $updated = new \DateTime();
            $updated->setDate(2012, rand(5, 11), rand(10, 20));
            $updated->format('Y-m-d');
            $list[$i]['updated'] = $updated;

            $deleted = new \DateTime();
            $deleted->setDate(2013, rand(1, 2), rand(10, 20));
            $deleted->format('Y-m-d');
            $list[$i]['deleted'] = $deleted;

        }

        return $list;
    }

    function getTitleAndDescriptionList()
    {
        $list = array();
        $i = 1;

        $titleFile = fopen(__DIR__ . "/title", "r");
        $descriptionFile = fopen(__DIR__ . "/description", "r");
        while (!feof($titleFile) || !feof($descriptionFile)) {
            $title = fgets($titleFile);
            $description = fgets($descriptionFile);
            $list[$i]['title'] = $title;
            $list[$i]['description'] = $description;
            $i++;
        }
        fclose($titleFile);
        fclose($descriptionFile);

        return $list;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 31;
    }

}
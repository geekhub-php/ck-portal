<?php
namespace Geekhub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $info = $this->setNameAndSurnameList();

        for ($i = 1; $i <= 17; $i++) {
            $userRef = 'user'.$i;

            $user = new User();
            $user->setName($info[$i]['name']);
            $user->setFirstName($info[$i]['surname']);
            $user->setUsername($userRef);
            $user->setEmail($userRef.'@ex.com.ua');
            $user->setPassword($userRef);
            $user->setProfilePicture($this->getReference('image' . $i)->getPath());
            $manager->persist($user);
            $manager->flush();

            $this->addReference($userRef, $user);

        }

        //Demo user
        $user = new User();
        $user->setName('Demo');
        $user->setFirstName('Demo');
        $user->setUsername('Demo');
        $user->setEmail('demo@gmail.com');
        $user->setPassword('demo');
        $manager->persist($user);
        $manager->flush();

        $this->addReference('userdemo', $user);
    }

    function setNameAndSurnameList()
    {
        $list = array();
        $i = 1;

        $nameFile = fopen(__DIR__."/name", "r");
        $surnameFile = fopen(__DIR__."/surname", "r");
        while (!feof($nameFile) || !feof($surnameFile)) {
            $name = fgets($nameFile);
            $surname = fgets($surnameFile);
            $list[$i]['name'] = $name;
            $list[$i]['surname'] = $surname;
            $i++;
        }
        fclose($nameFile);
        fclose($surnameFile);

        return $list;
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 11;
    }

}
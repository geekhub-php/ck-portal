<?php
namespace Geekhub\UserBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Behat\Gherkin\Node\TableNode;

use Geekhub\UserBundle\Entity\User;

class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function load(ObjectManager $manager)
    {
        $table = new TableNode(file_get_contents(__DIR__.'/user.gherkin'));
        $array = $table->getRows();
        for ($i = 1; isset($array[$i]); $i++) {
            $entity = new User();
            for ($col = 0; isset($array[$i][$col]); $col++) {
                $setter = 'set'.ucfirst($array[0][$col]);
                $entity->$setter($array[$i][$col]);
            }

            $this->setAdditionalInfo($entity);

            $manager->persist($entity);

            $this->addReference('user'.$i, $entity);
        }

        //Demo user
        $user = new User();
        $user->setName('Demo');
        $user->setFirstName('Demo');
        $user->setUsername('Demo');
        $user->setEmail('demo@gmail.com');
        $user->setPlainPassword('demo');
        $user->setLocked(false);
        $user->setEnabled(true);
        $user->setExpired(false);
        $manager->persist($user);

        $manager->flush();

        $this->addReference('userdemo', $user);
    }

    protected function setAdditionalInfo(User $entity)
    {
        $entity->setName($entity->getFirstName().' '.$entity->getLastName());
        $entity->setUsername($entity->getFirstName());
        $entity->setPlainPassword($entity->getFirstName());
        $entity->setLocked(false);
        $entity->setEnabled(true);
        $entity->setExpired(false);

        copy(__DIR__ . '/images/' . $entity->getProfilePicture(), $this->getUploadRootDir() . '/' . $entity->getProfilePicture());
        $entity->setProfilePicture($this->getUploadDir().'/'.$entity->getProfilePicture());
    }

    protected function getUploadRootDir()
    {
        return $this->container->get('kernel')->getRootdir() . '/../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
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
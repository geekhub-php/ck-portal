<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = array('jpeg', 'jpg', 'png');

        for ($i = 0; $i < 100; $i++) {
            $image = new Image();
            $image->setPath($this->getUploadDir());
            $image->setSize(rand(123456,654321));
            $image->setMimeType($type[rand(0,2)]);

            $this->addReference('image' . $i, $image);

            $manager->persist($image);
            $manager->flush();
        }
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'/../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 12;
    }


}
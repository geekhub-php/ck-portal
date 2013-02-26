<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\File;

class LoadFileData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $type = array('doc', 'xls', 'xslx', 'pdf');

        for ($i = 0; $i < 100; $i++) {
            $file = new File();

            $file->setPath($this->getUploadRootDir());
            $file->setSize(rand(123456,654321));
            $file->setType($type[rand(0,3)]);

            $this->addReference('file' . $i, $file);

            $manager->persist($file);
            $manager->flush();
        }
    }

    protected function getUploadRootDir()
    {
        return __DIR__.'../../../../../web/'.$this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/documents';
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
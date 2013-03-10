<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\Video;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $destDir = $this->container->getParameter('geekhub_file.video.upload_directory');
        $webDir = $this->container->get('kernel')->getRootDir() . '/../web/';
        $currentFile = $webDir . $destDir . 'video.jpg';

        if (!file_exists($webDir . $destDir)) {
            mkdir($webDir . $destDir);
        }

        copy(__DIR__ . '/srcFile/video.jpg', $currentFile);
        $list = $this->getVideoList();
        $type = array('vimeo', 'youtube');

        for ($i = 0; $i < 100; $i++) {
            $video = new Video();
            $currentType = $type[rand(0,1)];
            $currentLink = $list[rand(1, 30)][$currentType];

            $video->setType($currentType);
            $video->setLink($currentLink);
            $video->setThumbnail($destDir . 'video.jpg');
            $video->setRemoteThumbnail("http://www.direct-media.ru/ck_file/images/4.jpg");

            $manager->persist($video);
            $manager->flush();

            $this->addReference('video' . $i, $video);
        }
    }

    function getVideoList()
    {
        $i = 1;
        $vimeoFile = fopen(__DIR__ . "/vimeo", "r");
        $youtubeFile = fopen(__DIR__ . "/youtube", "r");
        while (!feof($vimeoFile) || !feof($youtubeFile)) {
            $vimeo = fgets($vimeoFile);
            $youtube = fgets($youtubeFile);
            $list[$i]['vimeo'] = $vimeo;
            $list[$i]['youtube'] = $youtube;
            $i++;
        }
        fclose($vimeoFile);
        fclose($youtubeFile);

        return $list;
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
        return 13;
    }


}
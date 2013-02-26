<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\Video;

class LoadVideoData extends AbstractFixture implements OrderedFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $list = $this->getVideoList();
        $type = array('vimeo', 'youtube');

        for ($i = 0; $i < 100; $i++) {
            $video = new Video();
            $currentType = $type[rand(0,1)];

            $video->setType($currentType);
            $video->setLink($list[rand(1, 30)][$currentType]);

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
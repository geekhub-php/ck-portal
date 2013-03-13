<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\Image;

class LoadImageData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 100; $i++) {
            $image = new Image();

            $currentImage = '0' . rand(1,9) . '.jpg';

            $binImage = new File(__DIR__ . '/image/' . $currentImage);
            $binImageName = $this->transliterate($binImage->getFilename(), null);
            $binImageSize = $binImage->getSize();
            $binImageExt = $binImage->getExtension();
            $binImageMime = $binImage->getMimeType();

            $destinationImageName = $this->getSlug($binImageName) . '___' . md5(uniqid() . $binImageName) . '.' . $binImageExt;

            $binImage->move($this->getUploadRootDir(), $destinationImageName);

            copy(__DIR__ . '/srcImage/' . $currentImage, __DIR__ . '/image/' . $currentImage);

            $image->setOriginalName($currentImage);
            $image->setPath($this->getUploadDir() . '/' . $destinationImageName);
            $image->setSize($binImageSize);
            $image->setMimeType($binImageMime);

            $this->addReference('image' . $i, $image);

            $manager->persist($image);
            $manager->flush();
        }
    }

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }


    protected function getUploadRootDir()
    {
        return $this->container->get('kernel')->getRootdir() . '/../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return 'uploads/images';
    }

    protected function getSlug($name)
    {
        return $this->container->get('fpn_tag.slugifier')->slugify($name);
    }

    function transliterate($textcyr = null, $textlat = null) {
        $cyr = array(
            'ж',  'ч',  'щ',   'ш',  'ю',  'а', 'б', 'в', 'г', 'д', 'e', 'з', 'и', 'й', 'к', 'л', 'м', 'н', 'о', 'п', 'р', 'с', 'т', 'у', 'ф', 'х', 'ц', 'ъ', 'ы','ь', 'я',
            'Ж',  'Ч',  'Щ',   'Ш',  'Ю',  'А', 'Б', 'В', 'Г', 'Д', 'Е', 'З', 'И', 'Й', 'К', 'Л', 'М', 'Н', 'О', 'П', 'Р', 'С', 'Т', 'У', 'Ф', 'Х', 'Ц', 'Ъ', 'Ы', 'Ь', 'Я');
        $lat = array(
            'zh', 'ch', 'shch', 'sh', 'yu', 'a', 'b', 'v', 'g', 'd', 'e', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o', 'p', 'r', 's', 't', 'u', 'f', 'h', 'c', '', 'y', '', 'ya',
            'Zh', 'Ch', 'Shch', 'Sh', 'Yu', 'A', 'B', 'V', 'G', 'D', 'E', 'Z', 'I', 'Y', 'K', 'L', 'M', 'N', 'O', 'P', 'R', 'S', 'T', 'U', 'F', 'H', 'c', '', 'Y', '', 'Ya');
        if($textcyr) return str_replace($cyr, $lat, $textcyr);
        else if($textlat) return str_replace($lat, $cyr, $textlat);
        else return null;
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
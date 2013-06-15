<?php
namespace Geekhub\FileBundle\DataFixtures\ORM;

use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Geekhub\FileBundle\Entity\Document as DreamFile;

class LoadDocumentData extends AbstractFixture implements OrderedFixtureInterface, ContainerAwareInterface
{
    /** @var ContainerInterface */
    private $container;

    public function load(ObjectManager $manager)
    {
        $type = array('doc.doc', 'xls.xls', 'xlsx.xlsx', 'pdf.pdf', 'doc1.doc');

        for ($i = 0; $i < 100; $i++) {
            $file = new DreamFile();

            $currentFile = $type[rand(0, 4)];

            $binFile = new File(__DIR__ . '/file/' . $currentFile);
            $binFileName = $this->transliterate($binFile->getFilename(), null);
            $binFileSize = $binFile->getSize();
            $binFileMimeType = $binFile->getMimeType();

            $destinationFileName = $this->getSlug($binFileName) . '___' . md5(uniqid() . $binFileName) . '.' . $binFile->getExtension();

            $binFile->move($this->getUploadRootDir(), $destinationFileName);

            copy(__DIR__ . '/srcFile/' . $currentFile, __DIR__ . '/file/' . $currentFile);

            $file->setPath($this->getUploadDir() . '/' . $destinationFileName);
            $file->setSize($binFileSize);
            $file->setMimeType($binFileMimeType);
            $file->setOriginalName($binFile->getFilename());

            $this->addReference('file' . $i, $file);

            $manager->persist($file);
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
        return $this->container->getParameter('geekhub_file.document.upload_directory');
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
        return 10;
    }


}
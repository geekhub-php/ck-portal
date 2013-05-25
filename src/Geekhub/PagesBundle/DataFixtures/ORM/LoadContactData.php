<?php
namespace Geekhub\PagesBundle\DataFixtures\ORM;

use Geekhub\PagesBundle\Entity\Contact;
use Geekhub\PagesBundle\DataFixtures\AbstractLoad;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class LoadContactData extends AbstractLoad
{
    public function __construct()
    {
        $this->setEntityName('contact');
    }

    protected function prePersist($entity)
    {
        copy(
            __DIR__.'/../Data/'.$entity->getPosition().'.png',
            __DIR__.'/../Data/'.$entity->getPosition().'-copy.png'
        );
        $file = new UploadedFile(__DIR__.'/../Data/'.$entity->getPosition().'-copy.png', $entity->getName(), null, null, null, true);
        $entity->setFile($file);
    }

    public function getNewObject()
    {
        return new Contact();
    }


    /**
     * Get the order of this fixture
     *
     * @return integer
     */
    function getOrder()
    {
        return 0;
    }
}
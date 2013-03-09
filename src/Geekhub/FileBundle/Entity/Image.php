<?php
namespace Geekhub\FileBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image extends File
{
    /** @ORM\ManyToOne(targetEntity="Geekhub\DreamBundle\Entity\Dream", inversedBy="image") */
    protected $dream;



    public function setDream(\Geekhub\DreamBundle\Entity\Dream $dream = null)
    {
        $this->dream = $dream;
    
        return $this;
    }

    public function getDream()
    {
        return $this->dream;
    }
}
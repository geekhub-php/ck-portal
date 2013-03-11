<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financial
 *
 * @ORM\Table(name="financial")
 * @ORM\Entity
 */
class Financial extends AbstractPoint
{
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="financial") */
    protected $dream;

    public function setDream($dream)
    {
        $this->dream = $dream;
    }

    public function getDream()
    {
        return $this->dream;
    }

    public function __toString()
    {
        return 'Financial';
    }
}
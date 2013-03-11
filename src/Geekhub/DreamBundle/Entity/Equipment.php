<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment extends AbstractPoint
{
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="equipment") */
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
        return 'Equipment';
    }
}
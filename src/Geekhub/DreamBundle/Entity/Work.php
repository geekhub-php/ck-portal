<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Work
 *
 * @ORM\Table(name="work")
 * @ORM\Entity
 */
class Work extends AbstractPoint
{
    /**
     * @var integer
     *
     * @ORM\Column(name="worker", type="integer")
     */
    protected $worker;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="work") */
    protected $dream;

    public function setDream($dream)
    {
        $this->dream = $dream;
    }

    public function getDream()
    {
        return $this->dream;
    }

    /**
     * @param int $worker
     */
    public function setWorker($worker)
    {
        $this->worker = $worker;
    }

    /**
     * @return int
     */
    public function getWorker()
    {
        return $this->worker;
    }

    public function __toString()
    {
        return 'Work';
    }
}
<?php

namespace Geekhub\PointBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=255)
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     */
    private $unit;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /**
     * @var integer
     *
     * @ORM\Column(name="dream_id", type="integer")
     */
    private $dream_id;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set item
     *
     * @param string $item
     * @return Equipment
     */
    public function setItem($item)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return string 
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set unit
     *
     * @param integer $unit
     * @return Equipment
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return integer 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set total
     *
     * @param integer $total
     * @return Equipment
     */
    public function setTotal($total)
    {
        $this->total = $total;
    
        return $this;
    }

    /**
     * Get total
     *
     * @return integer 
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set dream_id
     *
     * @param integer $dreamId
     * @return Equipment
     */
    public function setDreamId($dreamId)
    {
        $this->dream_id = $dreamId;
    
        return $this;
    }

    /**
     * Get dream_id
     *
     * @return integer 
     */
    public function getDreamId()
    {
        return $this->dream_id;
    }
}
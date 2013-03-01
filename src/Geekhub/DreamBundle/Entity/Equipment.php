<?php

namespace Geekhub\DreamBundle\Entity;

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
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="item", type="string", length=255)
     */
    protected $item;

    /**
     * @var integer
     *
     * @ORM\ManyToOne(targetEntity="Unit")
     */
    protected $unit;

    /**
     * @var integer
     *
     * @ORM\Column(name="total", type="integer")
     */
    protected $total;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="equipment") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="ContributorSupport", inversedBy="equipment") */
    protected $contribution;

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
     * Set unit
     *
     * @param \Geekhub\DreamBundle\Entity\Unit $unit
     * @return Equipment
     */
    public function setUnit(\Geekhub\DreamBundle\Entity\Unit $unit = null)
    {
        $this->unit = $unit;
    
        return $this;
    }

    /**
     * Get unit
     *
     * @return \Geekhub\DreamBundle\Entity\Unit 
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Set dream
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $dream
     * @return Equipment
     */
    public function setDream(\Geekhub\DreamBundle\Entity\Dream $dream = null)
    {
        $this->dream = $dream;
    
        return $this;
    }

    /**
     * Get dream
     *
     * @return \Geekhub\DreamBundle\Entity\Dream 
     */
    public function getDream()
    {
        return $this->dream;
    }

    /**
     * Set contribution
     *
     * @param \Geekhub\DreamBundle\Entity\ContributorSupport $contribution
     * @return Equipment
     */
    public function setContribution(\Geekhub\DreamBundle\Entity\ContributorSupport $contribution = null)
    {
        $this->contribution = $contribution;
    
        return $this;
    }

    /**
     * Get contribution
     *
     * @return \Geekhub\DreamBundle\Entity\ContributorSupport 
     */
    public function getContribution()
    {
        return $this->contribution;
    }
}
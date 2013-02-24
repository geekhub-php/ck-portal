<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financial
 *
 * @ORM\Table(name="financial")
 * @ORM\Entity
 */
class Financial
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
     * @ORM\Column(name="total", type="integer")
     */
    private $total;

    /** @ORM\ManyToOne(targetEntity="Point", inversedBy="financial") */
    private $point;

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
     * @return Financial
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
     * @return Financial
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
     * Set point
     *
     * @param \Geekhub\DreamBundle\Entity\Point $point
     * @return Financial
     */
    public function setPoint(\Geekhub\DreamBundle\Entity\Point $point = null)
    {
        $this->point = $point;
    
        return $this;
    }

    /**
     * Get point
     *
     * @return \Geekhub\DreamBundle\Entity\Point 
     */
    public function getPoint()
    {
        return $this->point;
    }
}
<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Financial
 *
 * @ORM\Table(name="point")
 * @ORM\Entity
 */
class Point
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /** @ORM\OneToMany(targetEntity="Financial", mappedBy="point") */
    private $financial;

    /** @ORM\OneToMany(targetEntity="Equipment", mappedBy="point") */
    private $equipment;

    /** @ORM\OneToMany(targetEntity="Work", mappedBy="point") */
    private $work;

    public function __construct()
    {
        $this->financial = new ArrayCollection();
        $this->equipment = new ArrayCollection();
        $this->work = new ArrayCollection();
    }

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
     * Set dream
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $dream
     * @return Point
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
     * Add financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     * @return Point
     */
    public function addFinancial(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financial[] = $financial;
    
        return $this;
    }

    /**
     * Remove financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     */
    public function removeFinancial(\Geekhub\DreamBundle\Entity\Financial $financial)
    {
        $this->financial->removeElement($financial);
    }

    /**
     * Get financial
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getFinancial()
    {
        return $this->financial;
    }

    /**
     * Add equipment
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     * @return Point
     */
    public function addEquipment(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipment[] = $equipment;
    
        return $this;
    }

    /**
     * Remove equipment
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $equipment
     */
    public function removeEquipment(\Geekhub\DreamBundle\Entity\Equipment $equipment)
    {
        $this->equipment->removeElement($equipment);
    }

    /**
     * Get equipment
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Add work
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     * @return Point
     */
    public function addWork(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->work[] = $work;
    
        return $this;
    }

    /**
     * Remove work
     *
     * @param \Geekhub\DreamBundle\Entity\Work $work
     */
    public function removeWork(\Geekhub\DreamBundle\Entity\Work $work)
    {
        $this->work->removeElement($work);
    }

    /**
     * Get work
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getWork()
    {
        return $this->work;
    }

    /**
     * Set point
     *
     * @param string $point
     * @return Point
     */
    public function setPoint($point)
    {
        $this->point = $point;
    
        return $this;
    }

    /**
     * Get point
     *
     * @return string 
     */
    public function getPoint()
    {
        return $this->point;
    }
}
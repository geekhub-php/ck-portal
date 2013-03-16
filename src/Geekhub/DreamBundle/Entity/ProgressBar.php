<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgressBar
 *
 * @ORM\Table()
 * @ORM\Entity
 */
class ProgressBar
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
     * @var integer
     *
     * @ORM\Column(name="finance", type="decimal", precision=4, scale=2, nullable=true)
     */
    private $finance;

    /**
     * @var integer
     *
     * @ORM\Column(name="equipment", type="decimal", precision=4, scale=2, nullable=true)
     */
    private $equipment;

    /**
     * @var integer
     *
     * @ORM\Column(name="work", type="decimal", precision=4, scale=2, nullable=true)
     */
    private $work;

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
     * Set finance
     *
     * @param integer $finance
     * @return ProgressBar
     */
    public function setFinance($finance)
    {
        $this->finance = $finance;
    
        return $this;
    }

    /**
     * Add finance
     *
     * @param integer $finance
     * @return ProgressBar
     */
    public function addFinance($finance)
    {
        $this->finance = $this->finance + $finance;

        return $this;
    }

    /**
     * Get finance
     *
     * @return integer 
     */
    public function getFinance()
    {
        return $this->finance;
    }

    /**
     * Set equipment
     *
     * @param integer $equipment
     * @return ProgressBar
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
    
        return $this;
    }

    /**
     * Add equipment
     *
     * @param integer $equipment
     * @return ProgressBar
     */
    public function addEquipment($equipment)
    {
        $this->equipment = $this->equipment + $equipment;

        return $this;
    }

    /**
     * Get equipment
     *
     * @return integer 
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * Set work
     *
     * @param integer $work
     * @return ProgressBar
     */
    public function setWork($work)
    {
        $this->work = $work;
    
        return $this;
    }

    /**
     * Add work
     *
     * @param integer $work
     * @return ProgressBar
     */
    public function addWork($work)
    {
        $this->work = $this->work + $work;

        return $this;
    }

    /**
     * Get work
     *
     * @return integer 
     */
    public function getWork()
    {
        return $this->work;
    }
}

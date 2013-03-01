<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Work
 *
 * @ORM\Table(name="work")
 * @ORM\Entity
 */
class Work
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
     * @ORM\Column(name="job", type="string", length=255)
     */
    protected $job;

    /**
     * @var integer
     *
     * @ORM\Column(name="employee", type="integer")
     */
    protected $employee;

    /**
     * @var integer
     *
     * @ORM\Column(name="day", type="integer")
     */
    protected $day;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="work") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="ContributorSupport", inversedBy="work") */
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
     * Set job
     *
     * @param string $job
     * @return Work
     */
    public function setJob($job)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return string 
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * Set employee
     *
     * @param integer $employee
     * @return Work
     */
    public function setEmployee($employee)
    {
        $this->employee = $employee;
    
        return $this;
    }

    /**
     * Get employee
     *
     * @return integer 
     */
    public function getEmployee()
    {
        return $this->employee;
    }

    /**
     * Set day
     *
     * @param integer $day
     * @return Work
     */
    public function setDay($day)
    {
        $this->day = $day;
    
        return $this;
    }

    /**
     * Get day
     *
     * @return integer 
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * Set dream
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $dream
     * @return Work
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
     * @return Work
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
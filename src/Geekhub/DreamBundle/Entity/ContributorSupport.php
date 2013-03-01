<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContributorSupport
 *
 * @ORM\Table(name="contributor_support")
 * @ORM\Entity
 */
class ContributorSupport
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /** @ORM\OneToMany(targetEntity="Financial", mappedBy="contribution", cascade={"persist", "remove"}) */
    protected $financial;

    /** @ORM\OneToMany(targetEntity="Equipment", mappedBy="contribution", cascade={"persist", "remove"}) */
    protected $equipment;

    /** @ORM\OneToMany(targetEntity="Work", mappedBy="contribution", cascade={"persist", "remove"}) */
    protected $work;

    /** @ORM\Column(name="hide", type="boolean") */
    protected $hide;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="contribution") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="contributions") */
    protected $user;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->financial = new \Doctrine\Common\Collections\ArrayCollection();
        $this->equipment = new \Doctrine\Common\Collections\ArrayCollection();
        $this->work = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Set hide
     *
     * @param boolean $hide
     * @return ContributorSupport
     */
    public function setHide($hide)
    {
        $this->hide = $hide;
    
        return $this;
    }

    /**
     * Get hide
     *
     * @return boolean 
     */
    public function getHide()
    {
        return $this->hide;
    }

    /**
     * Add financial
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $financial
     * @return ContributorSupport
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
     * @return ContributorSupport
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
     * @return ContributorSupport
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
     * Set dream
     *
     * @param \Geekhub\DreamBundle\Entity\Dream $dream
     * @return ContributorSupport
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
     * Set user
     *
     * @param \Geekhub\UserBundle\Entity\User $user
     * @return ContributorSupport
     */
    public function setUser(\Geekhub\UserBundle\Entity\User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return \Geekhub\UserBundle\Entity\User 
     */
    public function getUser()
    {
        return $this->user;
    }
}
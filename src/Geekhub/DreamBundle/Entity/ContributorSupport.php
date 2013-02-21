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
    private $id;

    /** @ORM\Column(name="point", type="object") */
    private $point;

    /** @ORM\Column(name="hide", type="boolean") */
    private $hide;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="contributions") */
    private $dream;

    /** @ORM\ManyToOne(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="contributions") */
    private $user;

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
     * Set point
     *
     * @param \stdClass $point
     * @return ContributorSupport
     */
    public function setPoint($point)
    {
        $this->point = $point;
    
        return $this;
    }

    /**
     * Get point
     *
     * @return \stdClass 
     */
    public function getPoint()
    {
        return $this->point;
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
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
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="work") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="\Geekhub\UserBundle\Entity\User", inversedBy="workDonates") */
    protected $user;

    /** @ORM\OneToMany(targetEntity="Work", mappedBy="parent") */
    private $children;

    /** @ORM\ManyToOne(targetEntity="Work", inversedBy="children") */
    private $parent;

    public function __construct()
    {
        $this->children = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function setDream($dream)
    {
        $this->dream = $dream;
    }

    public function getDream()
    {
        return $this->dream;
    }

    public function setUser(\Geekhub\UserBundle\Entity\User $user)
    {
        $this->user = $user;
        $user->addWorkDonate($this);
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add children
     *
     * @param \Geekhub\DreamBundle\Entity\Work $children
     * @return Work
     */
    public function addChildren(\Geekhub\DreamBundle\Entity\Work $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Geekhub\DreamBundle\Entity\Work $children
     */
    public function removeChildren(\Geekhub\DreamBundle\Entity\Work $children)
    {
        $this->children->removeElement($children);
    }

    /**
     * Get children
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Set parent
     *
     * @param \Geekhub\DreamBundle\Entity\Work $parent
     * @return Work
     */
    public function setParent(\Geekhub\DreamBundle\Entity\Work $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Geekhub\DreamBundle\Entity\Work
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return 'Work';
    }
}
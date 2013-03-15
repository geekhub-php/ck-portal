<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Financial
 *
 * @ORM\Table(name="financial")
 * @ORM\Entity
 */
class Financial extends AbstractPoint
{
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="financial") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="\Geekhub\UserBundle\Entity\User", inversedBy="financialDonates") */
    protected $user;

    /** @ORM\OneToMany(targetEntity="Financial", mappedBy="parent") */
    private $children;

    /** @ORM\ManyToOne(targetEntity="Financial", inversedBy="children") */
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
        $user->addFinancialDonate($this);
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add children
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $children
     * @return Financial
     */
    public function addChildren(\Geekhub\DreamBundle\Entity\Financial $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Geekhub\DreamBundle\Entity\Financial $children
     */
    public function removeChildren(\Geekhub\DreamBundle\Entity\Financial $children)
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
     * @param \Geekhub\DreamBundle\Entity\Financial $parent
     * @return Financial
     */
    public function setParent(\Geekhub\DreamBundle\Entity\Financial $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Geekhub\DreamBundle\Entity\Financial
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return 'Financial';
    }
}
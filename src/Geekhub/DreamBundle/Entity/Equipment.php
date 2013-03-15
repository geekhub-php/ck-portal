<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Equipment
 *
 * @ORM\Table(name="equipment")
 * @ORM\Entity
 */
class Equipment extends AbstractPoint
{
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="equipment") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="\Geekhub\UserBundle\Entity\User", inversedBy="equipmentDonates") */
    protected $user;

    /** @ORM\OneToMany(targetEntity="Equipment", mappedBy="parent") */
    private $children;

    /** @ORM\ManyToOne(targetEntity="Equipment", inversedBy="children") */
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
        $user->addEquipmentDonate($this);
    }

    public function getUser()
    {
        return $this->user;
    }

    /**
     * Add children
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $children
     * @return Equipment
     */
    public function addChildren(\Geekhub\DreamBundle\Entity\Equipment $children)
    {
        $this->children[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \Geekhub\DreamBundle\Entity\Equipment $children
     */
    public function removeChildren(\Geekhub\DreamBundle\Entity\Equipment $children)
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
     * @param \Geekhub\DreamBundle\Entity\Equipment $parent
     * @return Equipment
     */
    public function setParent(\Geekhub\DreamBundle\Entity\Equipment $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \Geekhub\DreamBundle\Entity\Equipment
     */
    public function getParent()
    {
        return $this->parent;
    }

    public function __toString()
    {
        return 'Equipment';
    }
}
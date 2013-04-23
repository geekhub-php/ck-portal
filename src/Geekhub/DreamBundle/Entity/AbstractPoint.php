<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\MappedSuperclass
 * @Gedmo\SoftDeleteable(fieldName="deletedAt")
 */
abstract class AbstractPoint
{
    /**
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;

    /** @ORM\Column(name="name", type="string") */
    protected $name;

    /** @ORM\Column(name="quantity", type="integer") */
    protected $quantity;

    /** @ORM\Column(name="hide", type="boolean") */
    protected $hide = 0;

    /** @ORM\Column(name="is_donate", type="boolean") */
    protected $isDonate = 0;

    /**
     * @ORM\Column(name="deletedAt", type="datetime", nullable=true)
     */
    protected $deletedAt;

    /** @ORM\Column(name="locked", type="boolean", nullable=true) */
    protected $locked;

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setHide($hide)
    {
        $this->hide = $hide;

        return $this;
    }

    public function getHide()
    {
        return $this->hide;
    }

    public function setIsDonate($isDonate)
    {
        $this->isDonate = $isDonate;

        return $this;
    }

    public function getIsDonate()
    {
        return $this->isDonate;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }

    public function setDeletedAt($deletedAt)
    {
        $this->deletedAt = $deletedAt;

        return $this;
    }

    public function getLocked()
    {
        return $this->locked;
    }

    public function setLocked($locked)
    {
        $this->locked = $locked;

        return $this;
    }
}
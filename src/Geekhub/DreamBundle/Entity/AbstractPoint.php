<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/** @ORM\MappedSuperclass */
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

    public function getId()
    {
        return $this->id;
    }

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    public function getQuantity()
    {
        return $this->quantity;
    }

    public function setHide($hide)
    {
        $this->hide = $hide;
    }

    public function getHide()
    {
        return $this->hide;
    }

    public function setIsDonate($isDonate)
    {
        $this->isDonate = $isDonate;
    }

    public function getIsDonate()
    {
        return $this->isDonate;
    }
}
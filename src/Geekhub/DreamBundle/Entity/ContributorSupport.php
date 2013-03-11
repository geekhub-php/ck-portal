<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ContributorSupport
 *
 * @ORM\Table(name="contributor_support")
 * @ORM\Entity()
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

    /** @ORM\Column(name="contribute_item", type="object") */
    protected $contributeItem;

    /** @ORM\Column(name="hide", type="boolean") */
    protected $hide;

    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="contribution") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="Geekhub\UserBundle\Entity\User", inversedBy="contributions") */
    protected $user;

    public function setContributeItem($contributeItem)
    {
        $this->contributeItem = $contributeItem;
    }

    public function getContributeItem()
    {
        return $this->contributeItem;
    }

    public function setDream($dream)
    {
        $this->dream = $dream;
    }

    public function getDream()
    {
        return $this->dream;
    }

    public function setHide($hide)
    {
        $this->hide = $hide;
    }

    public function getHide()
    {
        return $this->hide;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getUser()
    {
        return $this->user;
    }

}
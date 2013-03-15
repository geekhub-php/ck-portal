<?php

namespace Geekhub\DreamBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * OtherDonate
 *
 * @ORM\Table(name="other_donate")
 * @ORM\Entity
 */
class OtherDonate extends AbstractPoint
{
    /** @ORM\ManyToOne(targetEntity="Dream", inversedBy="otherDonate") */
    protected $dream;

    /** @ORM\ManyToOne(targetEntity="\Geekhub\UserBundle\Entity\User", inversedBy="otherDonates") */
    protected $user;

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
        $user->addOtherDonate($this);
    }

    public function getUser()
    {
        return $this->user;
    }

    public function __toString()
    {
        return 'OtherDonate';
    }
}
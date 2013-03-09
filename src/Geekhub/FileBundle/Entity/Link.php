<?php

namespace Geekhub\FileBundle\Entity;

abstract class Link
{
    protected $provider;

    protected $link;

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function getLink()
    {
        return $this->link;
    }

    public function setProvider($provider)
    {
        $this->provider = $provider;
    }

    public function getProvider()
    {
        return $this->provider;
    }


}
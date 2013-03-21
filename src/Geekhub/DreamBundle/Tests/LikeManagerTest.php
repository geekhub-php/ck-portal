<?php

namespace Geekhub\DreamBundle\Tests;

use Geekhub\DreamBundle\LikeManager;

class LikeManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testGetOkShareCount()
    {
        $likeManager = new LikeManager();

        $this->assertGreaterThan(3, $likeManager->getOkShareCount('http://wikipedia.org'));
    }

    public function testGetFbShareCount()
    {
        $likeManager = new LikeManager();

        $this->assertGreaterThan(19849, $likeManager->getFbShareCount('http://wikipedia.org'));
    }

    public function testGetTwShareCount()
    {
        $likeManager = new LikeManager();

        $this->assertGreaterThan(21, $likeManager->getTwShareCount('http://wikipedia.org'));
    }

    public function testGetVkShareCount()
    {
        $likeManager = new LikeManager();

        $this->assertGreaterThan(195, $likeManager->getVkShareCount('http://wikipedia.org'));
    }
}
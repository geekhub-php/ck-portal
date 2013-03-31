<?php

namespace Geekhub\DreamBundle\Tests;

use Geekhub\UserBundle\UserManager;
use Geekhub\UserBundle\Entity\User;

class UserManagerTest extends \PHPUnit_Framework_TestCase
{
    public function testIsFakeEmail()
    {
        $userManager = new UserManager();
        $user = new User();

        $this->assertEquals(true, $userManager->isFakeEmail($user->setEmail('123@vk.com')));
        $this->assertEquals(true, $userManager->isFakeEmail($user->setEmail('qwerty@odnoklassniki.ru')));
        $this->assertEquals(true, $userManager->isFakeEmail($user->setEmail('gogogo@vk.com')));
        $this->assertEquals(false, $userManager->isFakeEmail($user->setEmail('123@mail.ru')));
        $this->assertEquals(false, $userManager->isFakeEmail($user->setEmail('qwerty@ukr.net')));
        $this->assertEquals(false, $userManager->isFakeEmail($user->setEmail('gogogo@gmail.com')));
    }
}
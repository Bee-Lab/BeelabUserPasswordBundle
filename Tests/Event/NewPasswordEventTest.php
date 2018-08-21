<?php

namespace Beelab\UserPasswordBundle\Tests\Event;

use Beelab\UserBundle\User\UserInterface;
use Beelab\UserPasswordBundle\Event\NewPasswordEvent;
use PHPUnit\Framework\TestCase;

class NewPasswordEventTest extends TestCase
{
    public function testGetUser()
    {
        $user = $this->createMock(UserInterface::class);
        $event = new NewPasswordEvent($user, 'foo');
        $this->assertInstanceOf(UserInterface::class, $event->getUser());
    }

    public function testGetConfirmRoute()
    {
        $user = $this->createMock(UserInterface::class);
        $event = new NewPasswordEvent($user, 'bar');
        $this->assertEquals('bar', $event->getConfirmRoute());
    }
}

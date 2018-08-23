<?php

namespace Beelab\UserPasswordBundle\Tests\Event;

use Beelab\UserBundle\User\UserInterface;
use Beelab\UserPasswordBundle\Event\ChangePasswordEvent;
use PHPUnit\Framework\TestCase;

class ChangePasswordEventTest extends TestCase
{
    public function testGetUser(): void
    {
        $user = $this->createMock(UserInterface::class);
        $event = new ChangePasswordEvent($user);
        $this->assertInstanceOf(UserInterface::class, $event->getUser());
    }
}

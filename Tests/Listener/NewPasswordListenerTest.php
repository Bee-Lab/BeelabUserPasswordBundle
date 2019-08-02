<?php

namespace Beelab\UserPasswordBundle\Tests\Listener;

use Beelab\UserPasswordBundle\Listener\NewPasswordListener;
use PHPUnit\Framework\TestCase;

class NewPasswordListenerTest extends TestCase
{
    public function testOnRequest(): void
    {
        $manager = $this->createMock('Doctrine\Common\Persistence\ObjectManager');
        $mailer = $this->getMockBuilder('Beelab\UserPasswordBundle\Mailer\Mailer')
            ->disableOriginalConstructor()->getMock();
        $router = $this->createMock('Symfony\Component\Routing\RouterInterface');
        $class = 'StdClass';
        $event = $this->getMockBuilder('Beelab\UserPasswordBundle\Event\NewPasswordEvent')
            ->disableOriginalConstructor()->getMock();
        $router->expects($this->once())->method('generate')->willReturn('foo');
        $listener = new NewPasswordListener($manager, $mailer, $router, $class);
        $listener->onRequest($event);
    }
}

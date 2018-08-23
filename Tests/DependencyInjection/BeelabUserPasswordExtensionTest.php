<?php

namespace Beelab\UserPasswordBundle\Tests\DependencyInjection;

use Beelab\UserPasswordBundle\DependencyInjection\BeelabUserPasswordExtension;
use PHPUnit\Framework\TestCase;

class BeelabUserPasswordExtensionTest extends TestCase
{
    public function testLoadFailure(): void
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();
        $extension = $this
            ->getMockBuilder('Beelab\\UserPasswordBundle\\DependencyInjection\\BeelabUserPasswordExtension')->getMock();

        $extension->load([[]], $container);
        $this->assertFalse(false);
    }

    public function testLoadSetParameters(): void
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');

        $container->expects($this->any())->method('getParameterBag')->will($this->returnValue($parameterBag));

        $extension = new BeelabUserPasswordExtension();
        $configs = [
            ['password_min_length' => 10],
            ['password_reset_class' => 'foo'],
            ['password_reset_form_type' => 'foo'],
            ['new_password_form_type' => 'foo'],
            ['email_parameters' => ['template' => 'a', 'sender' => 'b', 'subject' => 'c']],
        ];
        $extension->load($configs, $container);
        $this->assertTrue(true);
    }
}

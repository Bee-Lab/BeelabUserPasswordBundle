<?php

namespace Beelab\UserPasswordBundle\Tests\DependencyInjection;

use Beelab\UserPasswordBundle\DependencyInjection\BeelabUserPasswordExtension;

class BeelabUserPasswordExtensionTest extends \PHPUnit_Framework_TestCase
{
    public function testLoadFailure()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();
        $extension = $this
            ->getMockBuilder('Beelab\\UserPasswordBundle\\DependencyInjection\\BeelabUserPasswordExtension')->getMock();

        $extension->load(array(array()), $container);
    }

    public function testLoadSetParameters()
    {
        $container = $this->getMockBuilder('Symfony\\Component\\DependencyInjection\\ContainerBuilder')
            ->disableOriginalConstructor()->getMock();
        $parameterBag = $this->getMockBuilder('Symfony\Component\DependencyInjection\ParameterBag\\ParameterBag')
            ->disableOriginalConstructor()->getMock();

        $parameterBag->expects($this->any())->method('add');

        $container->expects($this->any())->method('getParameterBag')->will($this->returnValue($parameterBag));

        $extension = new BeelabUserPasswordExtension();
        $configs = array(
            array('password_min_length' => 10),
            array('password_reset_class' => 'foo'),
            array('password_reset_form_type' => 'foo'),
            array('new_password_form_type' => 'foo'),
            array('email_parameters' => array('template' => 'a', 'sender' => 'b', 'subject' => 'c')),
        );
        $extension->load($configs, $container);
    }
}

<?php

namespace Beelab\UserPasswordBundle\Tests\Form\Type;

use Beelab\UserPasswordBundle\Form\Type\ResetPasswordType;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ResetPasswordTypeTest extends TypeTestCase
{
    protected function setUp()
    {
        parent::setUp();

        $validator = $this->getMock('\Symfony\Component\Validator\Validator\ValidatorInterface');
        $validator->method('validate')->will($this->returnValue(new ConstraintViolationList()));

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtension(new FormTypeValidatorExtension($validator))
            ->addTypeGuesser(
                $this->getMockBuilder('Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser')
                    ->disableOriginalConstructor()->getMock()
            )
            ->getFormFactory();

        $this->dispatcher = $this->getMock('Symfony\Component\EventDispatcher\EventDispatcherInterface');
        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    public function testSubmitValidData()
    {
        $formData = array(
            'email' => 'paperino@example.org',
        );

        $userManager = $this->getMockBuilder('\Beelab\UserBundle\Manager\UserManager')
            ->disableOriginalConstructor()->getMock();

        $type = new ResetPasswordType($userManager);
        $form = $this->factory->create($type, null, array('constraints' => array()));

        // send directly data to form
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());
    }
}

<?php

namespace Beelab\UserPasswordBundle\Tests\Form\Type;

use Beelab\UserPasswordBundle\Form\Type\ResetPasswordType;
use Symfony\Component\Form\Extension\Validator\Type\FormTypeValidatorExtension;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Forms;
use Symfony\Component\Form\PreloadedExtension;
use Symfony\Component\Form\Test\TypeTestCase;
use Symfony\Component\Validator\ConstraintViolationList;

class ResetPasswordTypeTest extends TypeTestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        $validator = $this->getMockBuilder('\Symfony\Component\Validator\Validator\ValidatorInterface')->getMock();
        $validator->method('validate')->willReturn(new ConstraintViolationList());

        $this->factory = Forms::createFormFactoryBuilder()
            ->addExtensions($this->getExtensions())
            ->addTypeExtension(new FormTypeValidatorExtension($validator))
            ->addTypeGuesser(
                $this->getMockBuilder('Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser')
                    ->disableOriginalConstructor()->getMock()
            )
            ->getFormFactory();

        $this->dispatcher = $this->getMockBuilder('Symfony\Component\EventDispatcher\EventDispatcherInterface')->getMock();
        $this->builder = new FormBuilder(null, null, $this->dispatcher, $this->factory);
    }

    protected function getExtensions()
    {
        $userManager = $this->getMockBuilder('\Beelab\UserBundle\Manager\UserManager')
            ->disableOriginalConstructor()->getMock();
        $type = new ResetPasswordType($userManager);

        return [
            // register the type instances with the PreloadedExtension
            new PreloadedExtension([$type], []),
        ];
    }

    public function testSubmitValidData(): void
    {
        $formData = [
            'email' => 'paperino@example.org',
        ];

        $form = $this->factory->create('Beelab\UserPasswordBundle\Form\Type\ResetPasswordType', null, ['constraints' => []]);

        // send directly data to form
        $form->submit($formData);

        $this->assertTrue($form->isSynchronized());
        $this->assertEquals($formData, $form->getData());
    }
}

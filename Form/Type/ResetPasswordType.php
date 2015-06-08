<?php

namespace Beelab\UserPasswordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ResetPasswordType.
 */
class ResetPasswordType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', ['constraints' => [new Assert\NotBlank(), new Assert\Email()]])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'beelab_reset_password';
    }
}

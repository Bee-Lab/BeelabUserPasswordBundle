<?php

namespace Beelab\UserPasswordBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Form for insert a new password.
 */
class NewPasswordType extends AbstractType
{
    /**
     * @var int
     */
    private $minLength;

    /**
     * @param int $minLength
     */
    public function __construct($minLength = 8)
    {
        $this->minLength = $minLength;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('password', 'Symfony\Component\Form\Extension\Core\Type\PasswordType', [
                'label' => 'New password',
                'constraints' => [new Assert\NotBlank(), new Assert\Length(['min' => $this->minLength])],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'beelab_new_password';
    }
}

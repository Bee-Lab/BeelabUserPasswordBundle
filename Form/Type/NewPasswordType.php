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
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', $this->isLegacy() ? 'password' : 'Symfony\Component\Form\Extension\Core\Type\PasswordType', array(
                'label' => 'New password',
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => $this->minLength))),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return $this->getName();
    }

    /**
     * BC for Symfony < 3.0.
     */
    public function getName()
    {
        return 'beelab_new_password';
    }

    /**
     * @return bool
     */
    private function isLegacy()
    {
        return !method_exists('Symfony\Component\Form\AbstractType', 'getBlockPrefix');
    }
}

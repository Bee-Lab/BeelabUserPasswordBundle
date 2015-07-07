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
    public function __construct($minLength)
    {
        $this->minLength = $minLength;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('password', 'password', array(
                'label'       => 'New password',
                'constraints' => array(new Assert\NotBlank(), new Assert\Length(array('min' => $this->minLength))),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'beelab_new_password';
    }
}

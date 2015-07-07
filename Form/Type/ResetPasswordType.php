<?php

namespace Beelab\UserPasswordBundle\Form\Type;

use Beelab\UserBundle\Manager\LightUserManager as UserManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;

/**
 * Form for reset password.
 */
class ResetPasswordType extends AbstractType
{
    /**
     * @var UserManager
     */
    private $userManager;

    /**
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', 'email', array(
                'constraints' => array(
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Callback(array($this, 'findUser')),
                ),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'beelab_reset_password';
    }

    /**
     * Find user by email.
     *
     * @param array                     $data
     * @param ExecutionContextInterface $context
     */
    public function findUser($data, ExecutionContextInterface $context)
    {
        if (is_null($this->userManager->find($data['email']))) {
            $context->addViolationAt('email', 'Email not found.');
        }
    }
}

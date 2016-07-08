<?php

namespace Beelab\UserPasswordBundle\Form\Type;

use Beelab\UserBundle\Manager\UserManager;
use Beelab\UserBundle\User\UserInterface;
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
     * @var UserInterface
     */
    private $user;

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
            ->add('email', 'Symfony\Component\Form\Extension\Core\Type\EmailType', [
                'constraints' => [
                    new Assert\NotBlank(),
                    new Assert\Email(),
                    new Assert\Callback([$this, 'findUser']),
                ],
            ])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'beelab_reset_password';
    }

    /**
     * Find user by email.
     *
     * @param string                    $email
     * @param ExecutionContextInterface $context
     */
    public function findUser($email, ExecutionContextInterface $context)
    {
        if (is_null($user = $this->userManager->loadUserByUsername($email))) {
            $context->addViolationAt('email', 'Email not found.');
        }
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}

<?php

namespace Beelab\UserPasswordBundle\Form\Type;

use Beelab\UserBundle\Manager\UserManager;
use Beelab\UserBundle\User\UserInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;

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

    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, ['constraints' => [
                new Assert\NotBlank(),
                new Assert\Email(),
                new Assert\Callback([$this, 'findUser']),
            ]])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'beelab_reset_password';
    }

    public function findUser(string $email, ExecutionContextInterface $context): void
    {
        try {
            $this->user = $this->userManager->loadUserByUsername($email);
        } catch (UsernameNotFoundException $exception) {
            $context->buildViolation('Email not found.')->atPath('email')->addViolation();
        }
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}

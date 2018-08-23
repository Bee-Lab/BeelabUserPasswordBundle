<?php

namespace Beelab\UserPasswordBundle\Entity;

use Beelab\UserBundle\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResetPassword.
 *
 * @ORM\MappedSuperclass()
 */
abstract class ResetPassword
{
    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var UserInterface
     *
     * You need to override this property and define a relation with your User entity
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(length=32, unique=true)
     */
    protected $token;

    public function __construct(UserInterface $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}

<?php

namespace Beelab\UserPasswordBundle\Entity;

use Beelab\UserBundle\User\UserInterface;
use Doctrine\ORM\Mapping as ORM;

/**
 * ResetPassword.
 *
 * @ORM\MappedSuperClass()
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
     */
    protected $user;

    /**
     * @var string
     *
     * @ORM\Column(length=32, unique=true)
     */
    protected $token;

    /**
     * @param UserInterface $user
     * @param string        $token
     */
    public function __construct(UserInterface $user, $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }
}

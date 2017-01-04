<?php

namespace Beelab\UserPasswordBundle\Event;

use Beelab\UserBundle\User\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is fired when a user change his/her password.
 */
class ChangePasswordEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @param UserInterface $user
     */
    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    /**
     * @return UserInterface
     */
    public function getUser(): UserInterface
    {
        return $this->user;
    }
}

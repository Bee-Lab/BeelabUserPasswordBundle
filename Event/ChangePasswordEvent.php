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

    public function __construct(UserInterface $user)
    {
        $this->user = $user;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }
}

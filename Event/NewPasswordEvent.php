<?php

namespace Beelab\UserPasswordBundle\Event;

use Beelab\UserBundle\User\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * This event is fired when a user requests a new password.
 */
class NewPasswordEvent extends Event
{
    /**
     * @var UserInterface
     */
    protected $user;

    /**
     * @var string
     */
    protected $confirmRoute;

    public function __construct(UserInterface $user, string $confirmRoute)
    {
        $this->user = $user;
        $this->confirmRoute = $confirmRoute;
    }

    public function getUser(): UserInterface
    {
        return $this->user;
    }

    public function getConfirmRoute(): string
    {
        return $this->confirmRoute;
    }
}

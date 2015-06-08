<?php

namespace Beelab\UserPasswordBundle\Event;

use Beelab\UserBundle\User\UserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * NewPasswordEvent.
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

    /**
     * @param UserInterface $user
     * @param string        $confirmRoute
     */
    public function __construct(UserInterface $user, $confirmRoute)
    {
        $this->user = $user;
        $this->confirmRoute = $confirmRoute;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getConfirmRoute()
    {
        return $this->confirmRoute;
    }
}

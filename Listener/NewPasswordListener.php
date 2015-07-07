<?php

namespace Beelab\UserPasswordBundle\Listener;

use Beelab\UserPasswordBundle\Entity\ResetPassword;
use Beelab\UserPasswordBundle\Event\NewPasswordEvent;
use Beelab\UserPasswordBundle\Mailer\Mailer;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Util\SecureRandomInterface;

/**
 * NewPasswordListener.
 */
class NewPasswordListener
{
    /**
     * @var ObjectManager
     */
    private $em;

    /**
     * @var Mailer
     */
    private $mailer;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var SecureRandomInterface
     */
    private $random;

    /**
     * @var string
     */
    private $appDir;

    /**
     * @param ObjectManager         $em
     * @param Mailer                $mailer
     * @param RouterInterface       $router
     * @param SecureRandomInterface $random
     * @param string                $appDir
     */
    public function __construct(ObjectManager $em, Mailer $mailer, RouterInterface $router, SecureRandomInterface $random, $appDir)
    {
        $this->em     = $em;
        $this->mailer = $mailer;
        $this->router = $router;
        $this->random = $random;
        $this->appDir = $appDir;
    }

    /**
     * @param NewPasswordEvent $event
     */
    public function onRequest(NewPasswordEvent $event)
    {
        $user = $event->getUser();
        $token = bin2hex($this->random->nextBytes(16));
        $resetPassword = new ResetPassword($user, $token);
        $this->em->persist($resetPassword);
        $this->em->flush();
        $url = $this->router->generate($event->getConfirmRoute(), array('token' => $token), RouterInterface::ABSOLUTE_URL);
        $this->mailer->sendResetPassword($url, $user);
    }
}

<?php

namespace Beelab\UserPasswordBundle\Mailer;

use Beelab\UserBundle\User\UserInterface;
use Swift_Mailer;
use Symfony\Bundle\FrameworkBundle\Templating\EngineInterface;

class Mailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @var EngineInterface
     */
    private $templating;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(Swift_Mailer $mailer, EngineInterface $templating, array $parameters)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
        $this->parameters = $parameters;
    }

    public function sendResetPassword(string $url, UserInterface $user): void
    {
        $template = $this->parameters['template'];
        $rendered = $this->templating->render($template, [
            'user' => $user,
            'url' => $url,
        ]);
        $message = $this->mailer
            ->createMessage()
            ->setSubject($this->parameters['subject'])
            ->setFrom($this->parameters['sender'])
            ->setTo($user->getUsername())   // username should be email
            ->setBody($rendered, 'text/html')
        ;
        if (!empty($this->parameters['bcc'])) {
            $message->setBcc($this->parameters['bcc']);
        }
        $this->mailer->send($message);
    }
}

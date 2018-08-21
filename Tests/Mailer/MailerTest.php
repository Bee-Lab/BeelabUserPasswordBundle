<?php

namespace Beelab\UserPasswordBundle\Tests\Mailer;

use Beelab\UserPasswordBundle\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testSendResetPassword()
    {
        $swift = $this->getMockBuilder('Swift_Mailer')->disableOriginalConstructor()->getMock();
        $templating = $this->createMock('Symfony\Bundle\FrameworkBundle\Templating\EngineInterface');
        $parameters = [
            'template' => 'bar',
            'subject' => 'A test',
            'sender' => 'noreply@example.org',
            'bcc' => 'info@example.org',
        ];
        $user = $this->createMock('Beelab\UserBundle\User\UserInterface');
        $message = $this->getMockBuilder('Swift_Message')->disableOriginalConstructor()->getMock();

        $user->expects($this->once())->method('getUsername')->will($this->returnValue('user@example.org'));
        $templating->expects($this->once())->method('render')->will($this->returnValue('blah blah'));
        $swift->expects($this->once())->method('createMessage')->will($this->returnValue($message));
        $swift->expects($this->once())->method('send')->will($this->returnValue(1));
        $message->expects($this->once())->method('setSubject')->with('A test')->will($this->returnSelf());
        $message->expects($this->once())->method('setFrom')->with('noreply@example.org')->will($this->returnSelf());
        $message->expects($this->once())->method('setTo')->with('user@example.org')->will($this->returnSelf());
        $message->expects($this->once())->method('setBody')->with('blah blah')->will($this->returnSelf());
        $message->expects($this->once())->method('setBcc')->with('info@example.org')->will($this->returnSelf());

        $mailer = new Mailer($swift, $templating, $parameters);
        $mailer->sendResetPassword('/foo', $user);
    }
}

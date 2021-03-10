<?php

/*
 * (c) Stéphane Ear <stephaneear@gmail.com>
 * 
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace AppBundle\Service;

use AppBundle\Entity\Message;
use Swift_Mailer;
use Swift_Message;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class AnnuaireMailer
{
    /**
     * @var Swift_Mailer
     */
    private $mailer;

    /**
     * @param Swift_Mailer $mailer
     */
    public function __construct(Swift_Mailer $mailer)
    {
        $this->mailer = $mailer;
    }
    
    public function handleMessage2(Message $message, &$errors)
    {
        $from = $message->getFrom();
        $to = $message->getTo();
        $body = $message->getBody();
        $object = $message->getObject();
        $replyTo = $message->getReplyTo();
        
        $mail = Swift_Message::newInstance()
            ->setSubject($object)
            ->setFrom($from)
            ->setTo($to)
            ->setReplyTo($replyTo)
            ->setBody($body, 'text/plain')
        ;

        return $this->mailer->send($mail, $errors);
    }
    public function handleMessage(Message $message, &$errors)
    {
        $email = new \SendGrid\Mail\Mail();
        $email->setFrom('climactif@hotmail.com', 'Climactif');
        $email->setSubject($message->getObject());
        $email->addTo($message->getTo());
        $email->addContent("text/plain", strip_tags($message->getBody()));
        $email->addContent(
            "text/html", $message->getBody()
        );
        $sendgrid = new \SendGrid('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');
        try {
            $response = $sendgrid->send($email);
            $wasSendingSuccessful = true;
        } catch (Exception $e) {
            $errors[] = $e->getMessage();
            $wasSendingSuccessful = false;
        }

        if ($wasSendingSuccessful) {
            return true;
        } else {
            return false;
        }
    }
}

<?php

namespace AppBundle\Service;

use AppBundle\Entity\Message;

/**
 * Haffoudhi
 */
class AnnuaireMailer
{
    private $api_key;

    public function __construct($api_key)
    {
        $this->api_key = $api_key;
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
        $sendgrid = new \SendGrid($this->api_key);
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

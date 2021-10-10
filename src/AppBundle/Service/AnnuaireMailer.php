<?php

namespace AppBundle\Service;

use AppBundle\Entity\Message;
use AppBundle\Entity\MessageProprietaire;

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
    
    public function handleMessage(Message $message, &$errors,  $dir='')
    {
        return $this->sendMail($message, $errors,  $dir);
    }
    
    public function handleMessageProprietaire(MessageProprietaire $message, &$errors,  $dir='')
    {
        return $this->sendMail($message, $errors,  $dir);
    }

    private function sendMail($message, &$errors,  $dir)
    {
        $email = new \SendGrid\Mail\Mail();
        // $email->setFrom('climactif@hotmail.com', 'Climactif');
        $email->setFrom('r.ammour@wkn-france.fr', 'WKN France');
        $email->setSubject($message->getObject());
        $email->addTo($message->getTo());
        $email->addContent("text/plain", strip_tags($message->getBody()));
        $logo = '<br><br><img width="200" src="https://www.climactif.com/images/wkn-france.png" alt="WKN France"><br>WKN France<br>10 Rue Charles Brunellière<br>44100 Nantes';
        $email->addContent(
            "text/html", str_replace("\n", '<br>', $message->getBody()).$logo
        );
        if ($message->getDocumentFile() && $message->getDocumentOriginalName()) {
        	$documentPath = $message->getDocumentFile();
        	$documentEncoded = base64_encode(file_get_contents($documentPath));
        	$documentType = mime_content_type($documentPath);
        	$email->addAttachment($documentEncoded, $documentType, $message->getDocumentOriginalName(), 'attachment');
		}
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

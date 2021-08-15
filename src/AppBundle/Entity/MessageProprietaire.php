<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Entité MessageProprietaire
 * 
 * Représente un message envoyé via Proprietaire
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 */
class MessageProprietaire
{
    use BlameableTrait;
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Proprietaire
     * 
     * @ORM\ManyToOne(targetEntity="Proprietaire", inversedBy="messages")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $proprietaire;
    
    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $exploitant = false;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="from_mail")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $from = 'r.ammour@wkn-france.fr';
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $replyTo = 'r.ammour@wkn-france.fr';
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="to_mail")
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    private $to;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $object;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $body;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->object;
    }
    
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return bool
     */
    public function isExploitant()
    {
        return $this->exploitant;
    }
    
    public function getFrom()
    {
        return $this->from;
    }

    public function getReplyTo()
    {
        return $this->replyTo;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function getObject()
    {
        return $this->object;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @param bool $expoitant
     * @return \AppBundle\Entity\MessageProprietaire
     */
    public function setExploitant($exploitant)
    {
        $this->exploitant = $exploitant;
        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;
        return $this;
    }

    public function setReplyTo($replyTo)
    {
        $this->replyTo = $replyTo;
        return $this;
    }

    public function setTo($to)
    {
        $this->to = $to;
        return $this;
    }

    public function setObject($object)
    {
        $this->object = $object;
        return $this;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }
    
    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    public function setProprietaire(Proprietaire $proprietaire)
    {
        $this->proprietaire = $proprietaire;
        return $this;
    }
}

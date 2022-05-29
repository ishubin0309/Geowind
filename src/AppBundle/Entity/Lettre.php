<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;
use DateTime;

/**
 * Entité Lettre
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 */
class Lettre
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
     * @var string
     * 
     */
    private $from = 'Expéditeur';

    /**
     * @var Projet
     * 
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="lettres")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $projet;

    /**
     * @var Mairie
     * 
     * @ORM\ManyToOne(targetEntity="Mairie", inversedBy="lettres")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $mairie;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="to_address")
     * @Assert\NotBlank()
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
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $result;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateReminder;

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
    
    public function getFrom()
    {
        return $this->from;
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

    public function getResult()
    {
        return $this->result;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setFrom($from)
    {
        $this->from = $from;
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

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateReminder()
    {
        return $this->dateReminder;
    }
    
    /**
     * @param DateTime|null $dateReminder
     * @return $this
     */
    public function setDateReminder(DateTime $dateReminder = null)
    {
        $this->dateReminder = $dateReminder;
        return $this;
    }
    
    public function getProjet()
    {
        return $this->projet;
    }

    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }
    
    public function getMairie()
    {
        return $this->mairie;
    }

    public function setMairie(Mairie $mairie)
    {
        $this->mairie = $mairie;
        return $this;
    }
}

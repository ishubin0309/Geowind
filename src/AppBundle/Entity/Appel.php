<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Appel
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 */
class Appel
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
    private $from = 'Enquêteur';

    /**
     * @var Mairie
     * 
     * @ORM\ManyToOne(targetEntity="Mairie", inversedBy="appels")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $mairie;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="to_phone")
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
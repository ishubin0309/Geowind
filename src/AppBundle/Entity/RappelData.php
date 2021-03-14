<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * RappelData entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class RappelData
{
    
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
     * @ORM\Column(type="string")
     */
    private $donnee;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $order;

    /**
     * @var Rappel
     *
     * @ORM\ManyToOne(targetEntity="Rappel", inversedBy="datas")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $rappel;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getDonnee()
    {
        return $this->donnee;
    }

    /**
     * @param string $donnee
     * @return \AppBundle\Entity\RappelData
     */
    public function setDonnee($donnee)
    {
        $this->donnee = $donnee;
        return $this;
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return \AppBundle\Entity\RappelData
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     *
     * @param string $note
     * @return \AppBundle\Entity\RappelData
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return int
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     *
     * @param int $order
     * @return \AppBundle\Entity\RappelData
     */
    public function setOrder($order)
    {
        $this->order = $order;
        return $this;
    }

    /**
     * @return Rappel
     */
    public function getRappel()
    {
        return $this->rappel;
    }

    /**
     * @param Rappel $rappel
     * @return \AppBundle\Entity\Rappel
     */
    public function setRappel(Rappel $rappel)
    {
        $this->rappel = $rappel;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'donnee';
    }
}

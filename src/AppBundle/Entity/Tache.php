<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Tache entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TacheRepository")
 * @ORM\Table()
 */
class Tache
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $objet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $dynamique;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="taches")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $projet;

    public function __construct()
    {
        $this->date = new DateTime('today');
    }

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
    public function getObjet()
    {
        return $this->objet;
    }

    /**
     * @param string $objet
     * @return \AppBundle\Entity\Tache
     */
    public function setObjet($objet)
    {
        $this->objet = $objet;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * @param string $etat
     * @return \AppBundle\Entity\Tache
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;
        return $this;
    }

    /**
     * @return string
     */
    public function getDynamique()
    {
        return $this->dynamique;
    }

    /**
     *
     * @param string $dynamique
     * @return \AppBundle\Entity\Tache
     */
    public function setDynamique($dynamique)
    {
        $this->dynamique = $dynamique;
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
     * @return \AppBundle\Entity\Tache
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @return DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * @param DateTime|null $date
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\Tache
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Tache';
    }
}

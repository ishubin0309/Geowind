<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Finance entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity
 */
class Finance
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
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="finances")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $projet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $phase;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $montantTotal;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $montantEngage;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $montantPaye;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=2)
     * @Assert\NotBlank()
     */
    private $montantRestant;

    /**
     * @var Bureau
     *
     * @ORM\ManyToOne(targetEntity="Bureau", inversedBy="finances")
     * @ORM\JoinColumn(nullable=false, onDelete="RESTRICT")
     */
    private $bureau;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @var bool
     *
     * @ORM\Column(type="integer", options={"default" : 0}, nullable=true)
     */
    private $duplique = 0;

    /**
     * @var DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     * @Assert\Date()
     */
    private $dateEngmt;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheance;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @param \AppBundle\Entity\Projet $projet
     * @return \AppBundle\Entity\Finance
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param string $phase
     * @return \AppBundle\Entity\Finance
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     * @param string $titre
     * @return \AppBundle\Entity\Finance
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return float
     */
    public function getMontant()
    {
        return floatval($this->montant);
    }

    /**
     * @param float $montant
     * @return \AppBundle\Entity\Finance
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;
        return $this;
    }

    /**
     * @return float
     */
    public function getPaye()
    {
        return floatval($this->paye);
    }

    /**
     * @param float $paye
     * @return \AppBundle\Entity\Finance
     */
    public function setPaye($paye)
    {
        $this->paye = $paye;
        return $this;
    }

    /**
     * @return Bureau
     */
    public function getBureau()
    {
        return $this->bureau;
    }

    /**
     * @param \AppBundle\Entity\Bureau $bureau
     * @return \AppBundle\Entity\Finance
     */
    public function setBureau(Bureau $bureau)
    {
        $this->bureau = $bureau;
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
     * @return \AppBundle\Entity\Finance
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @param bool $duplique
     * @return \AppBundle\Entity\Document
     */
    public function setDuplique($duplique)
    {
        $this->duplique = $duplique;
        return $this;
    }

    /**
     * @return bool
     */
    public function getDuplique()
    {
        return $this->duplique;
    }

    /**
     * @return DateTime
     */
    public function getDateEngmt()
    {
        return $this->dateEngmt;
    }

    /**
     * @param DateTime $dateEngmt
     * @return \AppBundle\Entity\Finance
     */
    public function setDateEngmt(DateTime $dateEngmt)
    {
        $this->dateEngmt = $dateEngmt;
        return $this;
    }
    
    /**
     * @return DateTime|null
     */
    public function getDateEcheance()
    {
        return $this->dateEcheance;
    }

    /**
     * @param DateTime|null $dateEcheance
     * @return $this
     */
    public function setDateEcheance(DateTime $dateEcheance = null)
    {
        $this->dateEcheance = $dateEcheance;
        return $this;
    }

    public function getMontantTotal()
    {
        return $this->montantTotal;
    }

    public function setMontantTotal($montantTotal)
    {
        $this->montantTotal = $montantTotal;
        return $this;
    }

    public function getMontantEngage()
    {
        return $this->montantEngage;
    }

    public function setMontantEngage($montantEngage)
    {
        $this->montantEngage = $montantEngage;
        return $this;
    }

    public function getMontantPaye()
    {
        return $this->montantPaye;
    }

    public function setMontantPaye($montantPaye)
    {
        $this->montantPaye = $montantPaye;
        return $this;
    }

    public function getMontantRestant()
    {
        return $this->montantRestant;
    }

    public function setMontantRestant($montantRestant)
    {
        $this->montantRestant = $montantRestant;
        return $this;
    }
}

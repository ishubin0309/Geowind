<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Contact
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity
 */
class Proprietaire
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
     * @ORM\Column(type="string")
     */
    private $parcelles;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $proprietaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneProprietaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresseProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailProprietaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateSignatureProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuNaissanceProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $exploitant;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneExploitant;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresseExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailExploitant;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordExploitant;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateSignatureExploitant;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceExploitant;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuNaissanceExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteExploitant;
    
    /**
     * @var ArrayCollection|Message[]
     * 
     * @ORM\OneToMany(targetEntity="MessageProprietaire", mappedBy="proprietaire")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    private $messages;
    
    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="proprietaires")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $projet;
        
    public function __construct()
    {
        $this->messages = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getParcelles()
    {
        return $this->parcelles;
    }

    public function getProprietaire()
    {
        return $this->proprietaire;
    }

    public function getTelephoneProprietaire()
    {
        return $this->telephoneProprietaire;
    }

    public function getAdresseProprietaire()
    {
        return $this->adresseProprietaire;
    }

    public function getEmailProprietaire()
    {
        return $this->emailProprietaire;
    }

    public function getExploitant()
    {
        return $this->exploitant;
    }

    public function getTelephoneExploitant()
    {
        return $this->telephoneExploitant;
    }

    public function getAdresseExploitant()
    {
        return $this->adresseExploitant;
    }

    public function getEmailExploitant()
    {
        return $this->emailExploitant;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }

    public function getProjet()
    {
        return $this->projet;
    }

    public function setParcelles($parcelles)
    {
        $this->parcelles = $parcelles;
        return $this;
    }

    public function setProprietaire($proprietaire)
    {
        $this->proprietaire = $proprietaire;
        return $this;
    }

    public function setTelephoneProprietaire($telephoneProprietaire)
    {
        $this->telephoneProprietaire = $telephoneProprietaire;
        return $this;
    }

    public function setAdresseProprietaire($adresseProprietaire)
    {
        $this->adresseProprietaire = $adresseProprietaire;
        return $this;
    }

    public function setEmailProprietaire($emailProprietaire)
    {
        $this->emailProprietaire = $emailProprietaire;
        return $this;
    }

    public function setExploitant($exploitant)
    {
        $this->exploitant = $exploitant;
        return $this;
    }

    public function setTelephoneExploitant($telephoneExploitant)
    {
        $this->telephoneExploitant = $telephoneExploitant;
        return $this;
    }

    public function setAdresseExploitant($adresseExploitant)
    {
        $this->adresseExploitant = $adresseExploitant;
        return $this;
    }

    public function setEmailExploitant($emailExploitant)
    {
        $this->emailExploitant = $emailExploitant;
        return $this;
    }
    
    public function getAccordProprietaire()
    {
        return $this->accordProprietaire;
    }

    public function getAccordExploitant()
    {
        return $this->accordExploitant;
    }

    public function setAccordProprietaire($accordProprietaire)
    {
        $this->accordProprietaire = $accordProprietaire;
        return $this;
    }

    public function setAccordExploitant($accordExploitant)
    {
        $this->accordExploitant = $accordExploitant;
        return $this;
    }

    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Projet $projet
     * @return $this
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }
    
    public function getDateSignatureProprietaire()
    {
        return $this->dateSignatureProprietaire;
    }

    public function getDateEcheanceProprietaire()
    {
        return $this->dateEcheanceProprietaire;
    }

    public function getDateNaissanceProprietaire()
    {
        return $this->dateNaissanceProprietaire;
    }

    public function getLieuNaissanceProprietaire()
    {
        return $this->lieuNaissanceProprietaire;
    }

    public function getCiviliteProprietaire()
    {
        return $this->civiliteProprietaire;
    }

    public function getDateSignatureExploitant()
    {
        return $this->dateSignatureExploitant;
    }

    public function getDateEcheanceExploitant()
    {
        return $this->dateEcheanceExploitant;
    }

    public function getDateNaissanceExploitant()
    {
        return $this->dateNaissanceExploitant;
    }

    public function getLieuNaissanceExploitant()
    {
        return $this->lieuNaissanceExploitant;
    }

    public function getCiviliteExploitant()
    {
        return $this->civiliteExploitant;
    }

    public function setDateSignatureProprietaire(DateTime $dateSignatureProprietaire = null)
    {
        $this->dateSignatureProprietaire = $dateSignatureProprietaire;
        return $this;
    }

    public function setDateEcheanceProprietaire(DateTime $dateEcheanceProprietaire = null)
    {
        $this->dateEcheanceProprietaire = $dateEcheanceProprietaire;
        return $this;
    }

    public function setDateNaissanceProprietaire(DateTime $dateNaissanceProprietaire = null)
    {
        $this->dateNaissanceProprietaire = $dateNaissanceProprietaire;
        return $this;
    }

    public function setLieuNaissanceProprietaire($lieuNaissanceProprietaire)
    {
        $this->lieuNaissanceProprietaire = $lieuNaissanceProprietaire;
        return $this;
    }

    public function setCiviliteProprietaire($civiliteProprietaire)
    {
        $this->civiliteProprietaire = $civiliteProprietaire;
        return $this;
    }

    public function setDateSignatureExploitant(DateTime $dateSignatureExploitant = null)
    {
        $this->dateSignatureExploitant = $dateSignatureExploitant;
        return $this;
    }

    public function setDateEcheanceExploitant(DateTime $dateEcheanceExploitant = null)
    {
        $this->dateEcheanceExploitant = $dateEcheanceExploitant;
        return $this;
    }

    public function setDateNaissanceExploitant(DateTime $dateNaissanceExploitant = null)
    {
        $this->dateNaissanceExploitant = $dateNaissanceExploitant;
        return $this;
    }

    public function setLieuNaissanceExploitant($lieuNaissanceExploitant)
    {
        $this->lieuNaissanceExploitant = $lieuNaissanceExploitant;
        return $this;
    }

    public function setCiviliteExploitant($civiliteExploitant)
    {
        $this->civiliteExploitant = $civiliteExploitant;
        return $this;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->parcelles;
    }
}

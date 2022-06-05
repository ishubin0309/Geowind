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
    private $proprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $proprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $proprietaire4;
    
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
    private $telephoneProprietaire2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneProprietaire3;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneProprietaire4;
    
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
    private $adresseProprietaire2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresseProprietaire3;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresseProprietaire4;

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
    private $emailProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailProprietaire4;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire3;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire4;
    
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
    private $dateSignatureProprietaire2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateSignatureProprietaire3;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateSignatureProprietaire4;
    
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
    private $dateEcheanceProprietaire2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceProprietaire3;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceProprietaire4;
    
    /**
     * @var string
     */
    private $dureeProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceProprietaire2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceProprietaire3;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceProprietaire4;

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
    private $lieuNaissanceProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuNaissanceProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuNaissanceProprietaire4;

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
    private $civiliteProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteProprietaire4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitProprietaire4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qualiteProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qualiteProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qualiteProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $qualiteProprietaire4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalProprietaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalProprietaire2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalProprietaire3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalProprietaire4;

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
    private $exploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $exploitant3;
    
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
    private $telephoneExploitant2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneExploitant3;
    
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
    private $adresseExploitant2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresseExploitant3;

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
    private $emailExploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailExploitant3;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordExploitant;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordExploitant2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordExploitant3;
    
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
    private $dateSignatureExploitant2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateSignatureExploitant3;
    
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
    private $dateEcheanceExploitant2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceExploitant3;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceExploitant;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceExploitant2;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateNaissanceExploitant3;

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
    private $lieuNaissanceExploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuNaissanceExploitant3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteExploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteExploitant3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitExploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $droitExploitant3;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $qualiteExploitant;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $qualiteExploitant2;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(type="string", nullable=true)
	 */
	private $qualiteExploitant3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalExploitant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalExploitant2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $maritalExploitant3;
    
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

    public function getProprietaire2()
    {
        return $this->proprietaire2;
    }

    public function getProprietaire3()
    {
        return $this->proprietaire3;
    }

    public function getProprietaire4()
    {
        return $this->proprietaire4;
    }

    public function getTelephoneProprietaire()
    {
        return $this->telephoneProprietaire;
    }

    public function getTelephoneProprietaire2()
    {
        return $this->telephoneProprietaire2;
    }

    public function getTelephoneProprietaire3()
    {
        return $this->telephoneProprietaire3;
    }

    public function getTelephoneProprietaire4()
    {
        return $this->telephoneProprietaire4;
    }

    public function getAdresseProprietaire()
    {
        return $this->adresseProprietaire;
    }

    public function getAdresseProprietaire2()
    {
        return $this->adresseProprietaire2;
    }

    public function getAdresseProprietaire3()
    {
        return $this->adresseProprietaire3;
    }

    public function getAdresseProprietaire4()
    {
        return $this->adresseProprietaire4;
    }

    public function getEmailProprietaire()
    {
        return $this->emailProprietaire;
    }

    public function getEmailProprietaire2()
    {
        return $this->emailProprietaire2;
    }

    public function getEmailProprietaire3()
    {
        return $this->emailProprietaire3;
    }

    public function getEmailProprietaire4()
    {
        return $this->emailProprietaire4;
    }

    public function getExploitant()
    {
        return $this->exploitant;
    }

    public function getExploitant2()
    {
        return $this->exploitant2;
    }

    public function getExploitant3()
    {
        return $this->exploitant3;
    }

    public function getTelephoneExploitant()
    {
        return $this->telephoneExploitant;
    }

    public function getTelephoneExploitant2()
    {
        return $this->telephoneExploitant2;
    }

    public function getTelephoneExploitant3()
    {
        return $this->telephoneExploitant3;
    }

    public function getAdresseExploitant()
    {
        return $this->adresseExploitant;
    }

    public function getAdresseExploitant2()
    {
        return $this->adresseExploitant2;
    }

    public function getAdresseExploitant3()
    {
        return $this->adresseExploitant3;
    }

    public function getEmailExploitant()
    {
        return $this->emailExploitant;
    }

    public function getEmailExploitant2()
    {
        return $this->emailExploitant2;
    }

    public function getEmailExploitant3()
    {
        return $this->emailExploitant3;
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

    public function setProprietaire2($proprietaire2)
    {
        $this->proprietaire2 = $proprietaire2;
        return $this;
    }

    public function setProprietaire3($proprietaire3)
    {
        $this->proprietaire3 = $proprietaire3;
        return $this;
    }

    public function setProprietaire4($proprietaire4)
    {
        $this->proprietaire4 = $proprietaire4;
        return $this;
    }

    public function setTelephoneProprietaire($telephoneProprietaire)
    {
        $this->telephoneProprietaire = $telephoneProprietaire;
        return $this;
    }

    public function setTelephoneProprietaire2($telephoneProprietaire2)
    {
        $this->telephoneProprietaire2 = $telephoneProprietaire2;
        return $this;
    }

    public function setTelephoneProprietaire3($telephoneProprietaire3)
    {
        $this->telephoneProprietaire3 = $telephoneProprietaire3;
        return $this;
    }

    public function setTelephoneProprietaire4($telephoneProprietaire4)
    {
        $this->telephoneProprietaire4 = $telephoneProprietaire4;
        return $this;
    }

    public function setAdresseProprietaire($adresseProprietaire)
    {
        $this->adresseProprietaire = $adresseProprietaire;
        return $this;
    }

    public function setAdresseProprietaire2($adresseProprietaire2)
    {
        $this->adresseProprietaire2 = $adresseProprietaire2;
        return $this;
    }

    public function setAdresseProprietaire3($adresseProprietaire3)
    {
        $this->adresseProprietaire3 = $adresseProprietaire3;
        return $this;
    }

    public function setAdresseProprietaire4($adresseProprietaire4)
    {
        $this->adresseProprietaire4 = $adresseProprietaire4;
        return $this;
    }

    public function setEmailProprietaire($emailProprietaire)
    {
        $this->emailProprietaire = $emailProprietaire;
        return $this;
    }

    public function setEmailProprietaire2($emailProprietaire2)
    {
        $this->emailProprietaire2 = $emailProprietaire2;
        return $this;
    }

    public function setEmailProprietaire3($emailProprietaire3)
    {
        $this->emailProprietaire3 = $emailProprietaire3;
        return $this;
    }

    public function setEmailProprietaire4($emailProprietaire4)
    {
        $this->emailProprietaire4 = $emailProprietaire4;
        return $this;
    }

    public function setExploitant($exploitant)
    {
        $this->exploitant = $exploitant;
        return $this;
    }

    public function setExploitant2($exploitant2)
    {
        $this->exploitant2 = $exploitant2;
        return $this;
    }

    public function setExploitant3($exploitant3)
    {
        $this->exploitant3 = $exploitant3;
        return $this;
    }

    public function setTelephoneExploitant($telephoneExploitant)
    {
        $this->telephoneExploitant = $telephoneExploitant;
        return $this;
    }

    public function setTelephoneExploitant2($telephoneExploitant2)
    {
        $this->telephoneExploitant2 = $telephoneExploitant2;
        return $this;
    }

    public function setTelephoneExploitant3($telephoneExploitant3)
    {
        $this->telephoneExploitant3 = $telephoneExploitant3;
        return $this;
    }

    public function setAdresseExploitant($adresseExploitant)
    {
        $this->adresseExploitant = $adresseExploitant;
        return $this;
    }

    public function setAdresseExploitant2($adresseExploitant2)
    {
        $this->adresseExploitant2 = $adresseExploitant2;
        return $this;
    }

    public function setAdresseExploitant3($adresseExploitant3)
    {
        $this->adresseExploitant3 = $adresseExploitant3;
        return $this;
    }

    public function setEmailExploitant($emailExploitant)
    {
        $this->emailExploitant = $emailExploitant;
        return $this;
    }

    public function setEmailExploitant2($emailExploitant2)
    {
        $this->emailExploitant2 = $emailExploitant2;
        return $this;
    }

    public function setEmailExploitant3($emailExploitant3)
    {
        $this->emailExploitant3 = $emailExploitant3;
        return $this;
    }
    
    public function getAccordProprietaire()
    {
        return $this->accordProprietaire;
    }
    
    public function getAccordProprietaire2()
    {
        return $this->accordProprietaire2;
    }
    
    public function getAccordProprietaire3()
    {
        return $this->accordProprietaire3;
    }
    
    public function getAccordProprietaire4()
    {
        return $this->accordProprietaire4;
    }

    public function getAccordExploitant()
    {
        return $this->accordExploitant;
    }

    public function getAccordExploitant2()
    {
        return $this->accordExploitant2;
    }

    public function getAccordExploitant3()
    {
        return $this->accordExploitant3;
    }

    public function setAccordProprietaire($accordProprietaire)
    {
        $this->accordProprietaire = $accordProprietaire;
        return $this;
    }

    public function setAccordProprietaire2($accordProprietaire2)
    {
        $this->accordProprietaire2 = $accordProprietaire2;
        return $this;
    }

    public function setAccordProprietaire3($accordProprietaire3)
    {
        $this->accordProprietaire3 = $accordProprietaire3;
        return $this;
    }

    public function setAccordProprietaire4($accordProprietaire4)
    {
        $this->accordProprietaire4 = $accordProprietaire4;
        return $this;
    }

    public function setAccordExploitant($accordExploitant)
    {
        $this->accordExploitant = $accordExploitant;
        return $this;
    }

    public function setAccordExploitant2($accordExploitant2)
    {
        $this->accordExploitant2 = $accordExploitant2;
        return $this;
    }

    public function setAccordExploitant3($accordExploitant3)
    {
        $this->accordExploitant3 = $accordExploitant3;
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
    
    public function getDateSignatureProprietaire2()
    {
        return $this->dateSignatureProprietaire2;
    }
    
    public function getDateSignatureProprietaire3()
    {
        return $this->dateSignatureProprietaire3;
    }
    
    public function getDateSignatureProprietaire4()
    {
        return $this->dateSignatureProprietaire4;
    }

    public function getDateEcheanceProprietaire()
    {
        return $this->dateEcheanceProprietaire;
    }

    public function getDateEcheanceProprietaire2()
    {
        return $this->dateEcheanceProprietaire2;
    }

    public function getDateEcheanceProprietaire3()
    {
        return $this->dateEcheanceProprietaire3;
    }

    public function getDateEcheanceProprietaire4()
    {
        return $this->dateEcheanceProprietaire4;
    }
    
    public function getDureeProprietaire()
    {
        if($this->dateEcheanceProprietaire && $this->dateSignatureProprietaire) {
            return $this->dateEcheanceProprietaire->format('Y') - $this->dateSignatureProprietaire->format('Y');
        }
        return '';
    }

    public function getDateNaissanceProprietaire()
    {
        return $this->dateNaissanceProprietaire;
    }

    public function getDateNaissanceProprietaire2()
    {
        return $this->dateNaissanceProprietaire2;
    }

    public function getDateNaissanceProprietaire3()
    {
        return $this->dateNaissanceProprietaire3;
    }

    public function getDateNaissanceProprietaire4()
    {
        return $this->dateNaissanceProprietaire4;
    }

    public function getLieuNaissanceProprietaire()
    {
        return $this->lieuNaissanceProprietaire;
    }

    public function getLieuNaissanceProprietaire2()
    {
        return $this->lieuNaissanceProprietaire2;
    }
	
	public function getLieuNaissanceProprietaire3()
	{
		return $this->lieuNaissanceProprietaire3;
	}
	
	public function getLieuNaissanceProprietaire4()
	{
		return $this->lieuNaissanceProprietaire4;
	}

    public function getCiviliteProprietaire()
    {
        return $this->civiliteProprietaire;
    }

    public function getCiviliteProprietaire2()
    {
        return $this->civiliteProprietaire2;
    }

    public function getCiviliteProprietaire3()
    {
        return $this->civiliteProprietaire3;
    }

    public function getCiviliteProprietaire4()
    {
        return $this->civiliteProprietaire4;
    }
	
	public function getDroitProprietaire()
	{
		return $this->droitProprietaire;
	}
	
	public function getDroitProprietaire2()
	{
		return $this->droitProprietaire2;
	}
	
	public function getDroitProprietaire3()
	{
		return $this->droitProprietaire3;
	}
	
	public function getDroitProprietaire4()
	{
		return $this->droitProprietaire4;
	}
	
	public function getQualiteProprietaire()
	{
		return $this->qualiteProprietaire;
	}
	
	public function getQualiteProprietaire2()
	{
		return $this->qualiteProprietaire2;
	}
	
	public function getQualiteProprietaire3()
	{
		return $this->qualiteProprietaire3;
	}
	
	public function getQualiteProprietaire4()
	{
		return $this->qualiteProprietaire4;
	}

    public function getMaritalProprietaire()
    {
        return $this->maritalProprietaire;
    }

    public function getMaritalProprietaire2()
    {
        return $this->maritalProprietaire2;
    }

    public function getMaritalProprietaire3()
    {
        return $this->maritalProprietaire3;
    }

    public function getMaritalProprietaire4()
    {
        return $this->maritalProprietaire4;
    }

    public function getDateSignatureExploitant()
    {
        return $this->dateSignatureExploitant;
    }

    public function getDateSignatureExploitant2()
    {
        return $this->dateSignatureExploitant2;
    }

    public function getDateSignatureExploitant3()
    {
        return $this->dateSignatureExploitant3;
    }

    public function getDateEcheanceExploitant()
    {
        return $this->dateEcheanceExploitant;
    }

    public function getDateEcheanceExploitant2()
    {
        return $this->dateEcheanceExploitant2;
    }

    public function getDateEcheanceExploitant3()
    {
        return $this->dateEcheanceExploitant3;
    }

    public function getDureeExploitant()
    {
        if($this->dateEcheanceExploitant && $this->dateSignatureExploitant) {
            return $this->dateEcheanceExploitant->format('Y') - $this->dateSignatureExploitant->format('Y');
        }
        return '';
    }

    public function getDateNaissanceExploitant()
    {
        return $this->dateNaissanceExploitant;
    }

    public function getDateNaissanceExploitant2()
    {
        return $this->dateNaissanceExploitant2;
    }

    public function getDateNaissanceExploitant3()
    {
        return $this->dateNaissanceExploitant3;
    }

    public function getLieuNaissanceExploitant()
    {
        return $this->lieuNaissanceExploitant;
    }

    public function getLieuNaissanceExploitant2()
    {
        return $this->lieuNaissanceExploitant2;
    }

    public function getLieuNaissanceExploitant3()
    {
        return $this->lieuNaissanceExploitant3;
    }

    public function getCiviliteExploitant()
    {
        return $this->civiliteExploitant;
    }

    public function getCiviliteExploitant2()
    {
        return $this->civiliteExploitant2;
    }

    public function getCiviliteExploitant3()
    {
        return $this->civiliteExploitant3;
    }

    public function getDroitExploitant()
    {
        return $this->droitExploitant;
    }

    public function getDroitExploitant2()
    {
        return $this->droitExploitant2;
    }

    public function getDroitExploitant3()
    {
        return $this->droitExploitant3;
    }

    public function getQualiteExploitant()
    {
        return $this->qualiteExploitant;
    }

    public function getQualiteExploitant2()
    {
        return $this->qualiteExploitant2;
    }

    public function getQualiteExploitant3()
    {
        return $this->qualiteExploitant3;
    }

    public function getMaritalExploitant()
    {
        return $this->maritalExploitant;
    }

    public function getMaritalExploitant2()
    {
        return $this->maritalExploitant2;
    }

    public function getMaritalExploitant3()
    {
        return $this->maritalExploitant3;
    }

    public function setDateSignatureProprietaire(DateTime $dateSignatureProprietaire = null)
    {
        $this->dateSignatureProprietaire = $dateSignatureProprietaire;
        return $this;
    }

    public function setDateSignatureProprietaire2(DateTime $dateSignatureProprietaire2 = null)
    {
        $this->dateSignatureProprietaire2 = $dateSignatureProprietaire2;
        return $this;
    }

    public function setDateSignatureProprietaire3(DateTime $dateSignatureProprietaire3 = null)
    {
        $this->dateSignatureProprietaire3 = $dateSignatureProprietaire3;
        return $this;
    }

    public function setDateSignatureProprietaire4(DateTime $dateSignatureProprietaire4 = null)
    {
        $this->dateSignatureProprietaire4 = $dateSignatureProprietaire4;
        return $this;
    }

    public function setDateEcheanceProprietaire(DateTime $dateEcheanceProprietaire = null)
    {
        $this->dateEcheanceProprietaire = $dateEcheanceProprietaire;
        return $this;
    }

    public function setDateEcheanceProprietaire2(DateTime $dateEcheanceProprietaire2 = null)
    {
        $this->dateEcheanceProprietaire2 = $dateEcheanceProprietaire2;
        return $this;
    }

    public function setDateEcheanceProprietaire3(DateTime $dateEcheanceProprietaire3 = null)
    {
        $this->dateEcheanceProprietaire3 = $dateEcheanceProprietaire3;
        return $this;
    }

    public function setDateEcheanceProprietaire4(DateTime $dateEcheanceProprietaire4 = null)
    {
        $this->dateEcheanceProprietaire4 = $dateEcheanceProprietaire4;
        return $this;
    }

    public function setDureeProprietaire($dureeProprietaire)
    {
        $this->dureeProprietaire = $dureeProprietaire;
        return $this;
    }

    public function setDateNaissanceProprietaire(DateTime $dateNaissanceProprietaire = null)
    {
        $this->dateNaissanceProprietaire = $dateNaissanceProprietaire;
        return $this;
    }

    public function setDateNaissanceProprietaire2(DateTime $dateNaissanceProprietaire2 = null)
    {
        $this->dateNaissanceProprietaire2 = $dateNaissanceProprietaire2;
        return $this;
    }

    public function setDateNaissanceProprietaire3(DateTime $dateNaissanceProprietaire3 = null)
    {
        $this->dateNaissanceProprietaire3 = $dateNaissanceProprietaire3;
        return $this;
    }

    public function setDateNaissanceProprietaire4(DateTime $dateNaissanceProprietaire4 = null)
    {
        $this->dateNaissanceProprietaire4 = $dateNaissanceProprietaire4;
        return $this;
    }

    public function setLieuNaissanceProprietaire($lieuNaissanceProprietaire)
    {
        $this->lieuNaissanceProprietaire = $lieuNaissanceProprietaire;
        return $this;
    }

    public function setLieuNaissanceProprietaire2($lieuNaissanceProprietaire2)
    {
        $this->lieuNaissanceProprietaire2 = $lieuNaissanceProprietaire2;
        return $this;
    }

    public function setLieuNaissanceProprietaire3($lieuNaissanceProprietaire3)
    {
        $this->lieuNaissanceProprietaire3 = $lieuNaissanceProprietaire3;
        return $this;
    }

    public function setLieuNaissanceProprietaire4($lieuNaissanceProprietaire4)
    {
        $this->lieuNaissanceProprietaire4 = $lieuNaissanceProprietaire4;
        return $this;
    }

    public function setCiviliteProprietaire($civiliteProprietaire)
    {
        $this->civiliteProprietaire = $civiliteProprietaire;
        return $this;
    }

    public function setCiviliteProprietaire2($civiliteProprietaire2)
    {
        $this->civiliteProprietaire2 = $civiliteProprietaire2;
        return $this;
    }

    public function setCiviliteProprietaire3($civiliteProprietaire3)
    {
        $this->civiliteProprietaire3 = $civiliteProprietaire3;
        return $this;
    }

    public function setCiviliteProprietaire4($civiliteProprietaire4)
    {
        $this->civiliteProprietaire4 = $civiliteProprietaire4;
        return $this;
    }

    public function setDroitProprietaire($droitProprietaire)
    {
        $this->droitProprietaire = $droitProprietaire;
        return $this;
    }

    public function setDroitProprietaire2($droitProprietaire2)
    {
        $this->droitProprietaire2 = $droitProprietaire2;
        return $this;
    }

    public function setDroitProprietaire3($droitProprietaire3)
    {
        $this->droitProprietaire3 = $droitProprietaire3;
        return $this;
    }

    public function setDroitProprietaire4($droitProprietaire4)
    {
        $this->droitProprietaire4 = $droitProprietaire4;
        return $this;
    }

    public function setQualiteProprietaire($qualiteProprietaire)
    {
        $this->qualiteProprietaire = $qualiteProprietaire;
        return $this;
    }

    public function setQualiteProprietaire2($qualiteProprietaire2)
    {
        $this->qualiteProprietaire2 = $qualiteProprietaire2;
        return $this;
    }

    public function setQualiteProprietaire3($qualiteProprietaire3)
    {
        $this->qualiteProprietaire3 = $qualiteProprietaire3;
        return $this;
    }

    public function setQualiteProprietaire4($qualiteProprietaire4)
    {
        $this->qualiteProprietaire4 = $qualiteProprietaire4;
        return $this;
    }

    public function setMaritalProprietaire($maritalProprietaire)
    {
        $this->maritalProprietaire = $maritalProprietaire;
        return $this;
    }

    public function setMaritalProprietaire2($maritalProprietaire2)
    {
        $this->maritalProprietaire2 = $maritalProprietaire2;
        return $this;
    }

    public function setMaritalProprietaire3($maritalProprietaire3)
    {
        $this->maritalProprietaire3 = $maritalProprietaire3;
        return $this;
    }

    public function setMaritalProprietaire4($maritalProprietaire4)
    {
        $this->maritalProprietaire4 = $maritalProprietaire4;
        return $this;
    }

    public function setDateSignatureExploitant(DateTime $dateSignatureExploitant = null)
    {
        $this->dateSignatureExploitant = $dateSignatureExploitant;
        return $this;
    }

    public function setDateSignatureExploitant2(DateTime $dateSignatureExploitant2 = null)
    {
        $this->dateSignatureExploitant2 = $dateSignatureExploitant2;
        return $this;
    }

    public function setDateSignatureExploitant3(DateTime $dateSignatureExploitant3 = null)
    {
        $this->dateSignatureExploitant3 = $dateSignatureExploitant3;
        return $this;
    }

    public function setDateEcheanceExploitant(DateTime $dateEcheanceExploitant = null)
    {
        $this->dateEcheanceExploitant = $dateEcheanceExploitant;
        return $this;
    }

    public function setDateEcheanceExploitant2(DateTime $dateEcheanceExploitant2 = null)
    {
        $this->dateEcheanceExploitant2 = $dateEcheanceExploitant2;
        return $this;
    }

    public function setDateEcheanceExploitant3(DateTime $dateEcheanceExploitant3 = null)
    {
        $this->dateEcheanceExploitant3 = $dateEcheanceExploitant3;
        return $this;
    }

    public function setDateNaissanceExploitant(DateTime $dateNaissanceExploitant = null)
    {
        $this->dateNaissanceExploitant = $dateNaissanceExploitant;
        return $this;
    }

    public function setDateNaissanceExploitant2(DateTime $dateNaissanceExploitant2 = null)
    {
        $this->dateNaissanceExploitant2 = $dateNaissanceExploitant2;
        return $this;
    }

    public function setDateNaissanceExploitant3(DateTime $dateNaissanceExploitant3 = null)
    {
        $this->dateNaissanceExploitant3 = $dateNaissanceExploitant3;
        return $this;
    }

    public function setLieuNaissanceExploitant($lieuNaissanceExploitant)
    {
        $this->lieuNaissanceExploitant = $lieuNaissanceExploitant;
        return $this;
    }

    public function setLieuNaissanceExploitant2($lieuNaissanceExploitant2)
    {
        $this->lieuNaissanceExploitant2 = $lieuNaissanceExploitant2;
        return $this;
    }

    public function setLieuNaissanceExploitant3($lieuNaissanceExploitant3)
    {
        $this->lieuNaissanceExploitant3 = $lieuNaissanceExploitant3;
        return $this;
    }

    public function setCiviliteExploitant($civiliteExploitant)
    {
        $this->civiliteExploitant = $civiliteExploitant;
        return $this;
    }

    public function setCiviliteExploitant2($civiliteExploitant2)
    {
        $this->civiliteExploitant2 = $civiliteExploitant2;
        return $this;
    }

    public function setCiviliteExploitant3($civiliteExploitant3)
    {
        $this->civiliteExploitant3 = $civiliteExploitant3;
        return $this;
    }

    public function setDroitExploitant($droitExploitant)
    {
        $this->droitExploitant = $droitExploitant;
        return $this;
    }

    public function setDroitExploitant2($droitExploitant2)
    {
        $this->droitExploitant2 = $droitExploitant2;
        return $this;
    }

    public function setDroitExploitant3($droitExploitant3)
    {
        $this->droitExploitant3 = $droitExploitant3;
        return $this;
    }
	
	public function setQualiteExploitant($qualiteExploitant)
	{
		$this->qualiteExploitant = $qualiteExploitant;
		return $this;
	}
	
	public function setQualiteExploitant2($qualiteExploitant2)
	{
		$this->qualiteExploitant2 = $qualiteExploitant2;
		return $this;
	}
	
	public function setQualiteExploitant3($qualiteExploitant3)
	{
		$this->qualiteExploitant3 = $qualiteExploitant3;
		return $this;
	}

    public function setMaritalExploitant($maritalExploitant)
    {
        $this->maritalExploitant = $maritalExploitant;
        return $this;
    }

    public function setMaritalExploitant2($maritalExploitant2)
    {
        $this->maritalExploitant2 = $maritalExploitant2;
        return $this;
    }

    public function setMaritalExploitant3($maritalExploitant3)
    {
        $this->maritalExploitant3 = $maritalExploitant3;
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

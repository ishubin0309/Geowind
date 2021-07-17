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
    private $accordProprietaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $accordProprietaire2;
    
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
    private $dateEcheanceProprietaire;
    
    /**
     * @var DateTime
     *
     * @ORM\Column(type="date", nullable=true)
     * @Assert\Date()
     */
    private $dateEcheanceProprietaire2;
    
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
    private $maritalExploitant;
    
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

    public function getTelephoneProprietaire()
    {
        return $this->telephoneProprietaire;
    }

    public function getTelephoneProprietaire2()
    {
        return $this->telephoneProprietaire2;
    }

    public function getAdresseProprietaire()
    {
        return $this->adresseProprietaire;
    }

    public function getAdresseProprietaire2()
    {
        return $this->adresseProprietaire2;
    }

    public function getEmailProprietaire()
    {
        return $this->emailProprietaire;
    }

    public function getEmailProprietaire2()
    {
        return $this->emailProprietaire2;
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

    public function setProprietaire2($proprietaire2)
    {
        $this->proprietaire2 = $proprietaire2;
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
    
    public function getAccordProprietaire2()
    {
        return $this->accordProprietaire2;
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

    public function setAccordProprietaire2($accordProprietaire2)
    {
        $this->accordProprietaire2 = $accordProprietaire2;
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
    
    public function getDateSignatureProprietaire2()
    {
        return $this->dateSignatureProprietaire2;
    }

    public function getDateEcheanceProprietaire()
    {
        return $this->dateEcheanceProprietaire;
    }

    public function getDateEcheanceProprietaire2()
    {
        return $this->dateEcheanceProprietaire2;
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

    public function getLieuNaissanceProprietaire()
    {
        return $this->lieuNaissanceProprietaire;
    }

    public function getLieuNaissanceProprietaire2()
    {
        return $this->lieuNaissanceProprietaire2;
    }

    public function getCiviliteProprietaire()
    {
        return $this->civiliteProprietaire;
    }

    public function getCiviliteProprietaire2()
    {
        return $this->civiliteProprietaire2;
    }
	
	public function getDroitProprietaire()
	{
		return $this->droitProprietaire;
	}
	
	public function getDroitProprietaire2()
	{
		return $this->droitProprietaire2;
	}
	
	public function getQualiteProprietaire()
	{
		return $this->qualiteProprietaire;
	}
	
	public function getQualiteProprietaire2()
	{
		return $this->qualiteProprietaire2;
	}

    public function getMaritalProprietaire()
    {
        return $this->maritalProprietaire;
    }

    public function getMaritalProprietaire2()
    {
        return $this->maritalProprietaire2;
    }

    public function getDateSignatureExploitant()
    {
        return $this->dateSignatureExploitant;
    }

    public function getDateEcheanceExploitant()
    {
        return $this->dateEcheanceExploitant;
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

    public function getLieuNaissanceExploitant()
    {
        return $this->lieuNaissanceExploitant;
    }

    public function getCiviliteExploitant()
    {
        return $this->civiliteExploitant;
    }

    public function getDroitExploitant()
    {
        return $this->droitExploitant;
    }

    public function getMaritalExploitant()
    {
        return $this->maritalExploitant;
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

    public function setMaritalProprietaire($maritalProprietaire)
    {
        $this->maritalProprietaire = $maritalProprietaire;
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

    public function setDroitExploitant($droitExploitant)
    {
        $this->droitExploitant = $droitExploitant;
        return $this;
    }

    public function setMaritalExploitant($maritalExploitant)
    {
        $this->maritalExploitant = $maritalExploitant;
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

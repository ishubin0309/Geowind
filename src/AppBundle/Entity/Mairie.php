<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Mairie entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\MairieRepository")
 * @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"commune"})})
 */
class Mairie
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
    private $classement;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $mairie;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $address1;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $address2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $codePostal;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $commune;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $civiliteMaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $prenomMaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nomMaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephone;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $fax;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $population2016;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email1;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email2;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email3;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email4;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email5;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $siteInternet;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $insee;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $canton2015;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $canton2014;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $siren;
    
    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $region;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $horaire;
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $elus = [];
    
    /**
     * @var ArrayCollection|Message[]
     * 
     * @ORM\OneToMany(targetEntity="Message", mappedBy="mairie")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    private $messages;
    
    /**
     * @var ArrayCollection|Appel[]
     * 
     * @ORM\OneToMany(targetEntity="Appel", mappedBy="mairie")
     * @ORM\OrderBy({"createdAt" = "ASC"})
     */
    private $appels;

    /**
     * @var ArrayCollection|Projet[]
     *
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="mairie")
     */
    private $projets;
        
    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->appels = new ArrayCollection();
        $this->projets = new ArrayCollection();
    }
    
    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    public function getClassement()
    {
        return $this->classement;
    }

    public function getMairie()
    {
        return trim(str_replace(array('Mairie d\'', 'Mairie de ', 'Mairie du '), '', $this->mairie));
    }

    public function getAddress1()
    {
        return $this->address1;
    }

    public function getAddress2()
    {
        return $this->address2;
    }

    public function getCodePostal()
    {
        return $this->codePostal;
    }

    public function getCommune()
    {
        return $this->commune;
    }

    public function getCiviliteMaire()
    {
        return $this->civiliteMaire;
    }

    public function getPrenomMaire()
    {
        return $this->prenomMaire;
    }

    public function getNomMaire()
    {
        return $this->nomMaire;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function getPopulation2016()
    {
        return $this->population2016;
    }

    public function getEmail1()
    {
        return $this->email1;
    }

    public function getEmail2()
    {
        return $this->email2;
    }

    public function getEmail3()
    {
        return $this->email3;
    }

    public function getEmail4()
    {
        return $this->email4;
    }

    public function getEmail5()
    {
        return $this->email5;
    }

    public function getSiteInternet()
    {
        return $this->siteInternet;
    }

    public function getInsee()
    {
        return $this->insee;
    }

    public function getCanton2015()
    {
        return $this->canton2015;
    }

    public function getCanton2014()
    {
        return $this->canton2014;
    }

    public function getSiren()
    {
        return $this->siren;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getHoraire()
    {
        return $this->horaire;
    }

    public function getElus()
    {
        return $this->elus ? \unserialize($this->elus) : [];
    }

    public function setClassement($classement)
    {
        $this->classement = $classement;
        return $this;
    }

    public function setMairie($mairie)
    {
        $this->mairie = $mairie;
        return $this;
    }

    public function setAddress1($address1)
    {
        $this->address1 = $address1;
        return $this;
    }

    public function setAddress2($address2)
    {
        $this->address2 = $address2;
        return $this;
    }

    public function setCodePostal($codePostal)
    {
        $this->codePostal = $codePostal;
        return $this;
    }

    public function setCommune($commune)
    {
        $this->commune = $commune;
        return $this;
    }

    public function setCiviliteMaire($civiliteMaire)
    {
        $this->civiliteMaire = $civiliteMaire;
        return $this;
    }

    public function setPrenomMaire($prenomMaire)
    {
        $this->prenomMaire = $prenomMaire;
        return $this;
    }

    public function setNomMaire($nomMaire)
    {
        $this->nomMaire = $nomMaire;
        return $this;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
        return $this;
    }

    public function setPopulation2016($population2016)
    {
        $this->population2016 = $population2016;
        return $this;
    }

    public function setEmail1($email1)
    {
        $this->email1 = $email1;
        return $this;
    }

    public function setEmail2($email2)
    {
        $this->email2 = $email2;
        return $this;
    }

    public function setEmail3($email3)
    {
        $this->email3 = $email3;
        return $this;
    }

    public function setEmail4($email4)
    {
        $this->email4 = $email4;
        return $this;
    }

    public function setEmail5($email5)
    {
        $this->email5 = $email5;
        return $this;
    }

    public function setSiteInternet($siteInternet)
    {
        $this->siteInternet = $siteInternet;
        return $this;
    }

    public function setInsee($insee)
    {
        $this->insee = $insee;
        return $this;
    }

    public function setCanton2015($canton2015)
    {
        $this->canton2015 = $canton2015;
        return $this;
    }

    public function setCanton2014($canton2014)
    {
        $this->canton2014 = $canton2014;
        return $this;
    }

    public function setSiren($siren)
    {
        $this->siren = $siren;
        return $this;
    }

    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    public function setHoraire($horaire)
    {
        $this->horaire = $horaire;
        return $this;
    }

    public function setElus(Array $elus)
    {
        $this->elus = \serialize($elus);
        return $this;
    }
    
    public function getMessages()
    {
        return $this->messages;
    }

    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
        return $this;
    }
    
    public function getAppels()
    {
        return $this->appels;
    }

    public function setAppels(ArrayCollection $appels)
    {
        $this->appels = $appels;
        return $this;
    }

    /**
     * @return ArrayCollection|Projet[]
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * @param ArrayCollection $projets
     * @return \AppBundle\Entity\Commune
     */
    public function setProjets(ArrayCollection $projets)
    {
        $this->projets = $projets;
        return $this;
    }
        
    /**
     * @return string
     */
    public function __toString()
    {
        return trim(str_replace(array('Mairie d\'', 'Mairie de ', 'Mairie du '), '', $this->mairie));
    }
}

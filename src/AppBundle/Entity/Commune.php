<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Commune entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\CommuneRepository")
 * @ORM\Table(indexes={@ORM\Index(name="search_idx", columns={"nom"})})
 */
class Commune
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
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $insee;

    /**
     * @var Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nomPresident;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephonePresident;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailPresident;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $nomMiniscule;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $communePop;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $communeCp;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $intercommunalite; // EPCI

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $intercommunaliteNb;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $intercommunalitePop;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $intercommunaliteCp;

    /**
     * @var string
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $intercommunaliteEpci; // EPCI siren

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $vitesseVent;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productiblePv;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $urbanismeType;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $urbanismeEtat;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer", nullable=true)
     */
    private $altitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $relief;

    /**
     * @var ArrayCollection|Projet[]
     *
     * @ORM\ManyToMany(targetEntity="Projet", mappedBy="communes")
     */
    private $projets;

    public function __construct()
    {
        $this->projets = new ArrayCollection();
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return \AppBundle\Entity\Commune
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return \AppBundle\Entity\Commune
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getInsee()
    {
        return $this->insee;
    }

    /**
     *
     * @param string $insee
     * @return \AppBundle\Entity\Geo\Commune
     */
    public function setInsee($insee)
    {
        $this->insee = $insee;
        return $this;
    }

    /**
     * @return Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param Departement $departement
     * @return \AppBundle\Entity\Commune
     */
    public function setDepartement(Departement $departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomPresident()
    {
        return $this->nomPresident;
    }

    /**
     * @param string $nomPresident
     * @return \AppBundle\Entity\Commune
     */
    public function setNomPresident($nomPresident)
    {
        $this->nomPresident = $nomPresident;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephonePresident()
    {
        return $this->telephonePresident;
    }

    /**
     * @param string $telephonePresident
     * @return \AppBundle\Entity\Commune
     */
    public function setTelephonePresident($telephonePresident)
    {
        $this->telephonePresident = $telephonePresident;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmailPresident()
    {
        return $this->emailPresident;
    }

    /**
     * @param string $emailPresident
     * @return \AppBundle\Entity\Commune
     */
    public function setEmailPresident($emailPresident)
    {
        $this->emailPresident = $emailPresident;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomMiniscule()
    {
        return $this->nomMiniscule;
    }

    /**
     * @param string $nomMiniscule
     * @return \AppBundle\Entity\Commune
     */
    public function setNomMiniscule($nomMiniscule)
    {
        $this->nomMiniscule = $nomMiniscule;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntercommunalite()
    {
        return $this->intercommunalite;
    }

    /**
     * @param string $intercommunalite
     * @return \AppBundle\Entity\Commune
     */
    public function setIntercommunalite($intercommunalite)
    {
        if($intercommunalite) $this->intercommunalite = $intercommunalite;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntercommunaliteNb()
    {
        return $this->intercommunaliteNb;
    }

    /**
     * @param string $intercommunaliteNb
     * @return \AppBundle\Entity\Commune
     */
    public function setIntercommunaliteNb($intercommunaliteNb)
    {
        if($intercommunaliteNb) $this->intercommunaliteNb = $intercommunaliteNb;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommunePop()
    {
        return $this->communePop;
    }

    /**
     * @param string $communePop
     * @return \AppBundle\Entity\Commune
     */
    public function setCommunePop($communePop)
    {
        if($communePop) $this->communePop = $communePop;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommuneCp()
    {
        return $this->communeCp;
    }

    /**
     * @param string $communeCp
     * @return \AppBundle\Entity\Commune
     */
    public function setCommuneCp($communeCp)
    {
        if($communeCp) $this->communeCp = $communeCp;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntercommunalitePop()
    {
        return $this->intercommunalitePop;
    }

    /**
     * @param string $intercommunalitePop
     * @return \AppBundle\Entity\Commune
     */
    public function setIntercommunalitePop($intercommunalitePop)
    {
        if($intercommunalitePop) $this->intercommunalitePop = $intercommunalitePop;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntercommunaliteCp()
    {
        return $this->intercommunaliteCp;
    }

    /**
     * @param string $intercommunaliteCp
     * @return \AppBundle\Entity\Commune
     */
    public function setIntercommunaliteCp($intercommunaliteCp)
    {
        if($intercommunaliteCp) $this->intercommunaliteCp = $intercommunaliteCp;
        return $this;
    }

    /**
     * @return string
     */
    public function getIntercommunaliteEpci()
    {
        return $this->intercommunaliteEpci;
    }

    /**
     * @param string $intercommunaliteEpci
     * @return \AppBundle\Entity\Commune
     */
    public function setIntercommunaliteEpci($intercommunaliteEpci)
    {
        if($intercommunaliteEpci) $this->intercommunaliteEpci = $intercommunaliteEpci;
        return $this;
    }

    /**
     * @return string
     */
    public function getVitesseVent()
    {
        return $this->vitesseVent;
    }

    /**
     * @param string $vitesseVent
     * @return \AppBundle\Entity\Commune
     */
    public function setVitesseVent($vitesseVent)
    {
        $this->vitesseVent = $vitesseVent;
        return $this;
    }

    /**
     * @return integer
     */
    public function getProductiblePv()
    {
        return $this->productiblePv;
    }

    /**
     * @param integer $productiblePv
     * @return \AppBundle\Entity\Commune
     */
    public function setProductiblePv($productiblePv)
    {
        if($productiblePv) $this->productiblePv = $productiblePv;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrbanismeType()
    {
        return $this->urbanismeType;
    }

    /**
     * @param string $urbanismeType
     * @return \AppBundle\Entity\Commune
     */
    public function setUrbanismeType($urbanismeType)
    {
        $this->urbanismeType = $urbanismeType;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrbanismeEtat()
    {
        return $this->urbanismeEtat;
    }

    /**
     * @param string $urbanismeEtat
     * @return \AppBundle\Entity\Commune
     */
    public function setUrbanismeEtat($urbanismeEtat)
    {
        $this->urbanismeEtat = $urbanismeEtat;
        return $this;
    }

    /**
     * @return integer
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param integer $altitude
     * @return \AppBundle\Entity\Commune
     */
    public function setAltitude($altitude)
    {
        if($altitude) $this->altitude = $altitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getRelief()
    {
        return $this->relief;
    }

    /**
     * @param string $relief
     * @return \AppBundle\Entity\Commune
     */
    public function setRelief($relief)
    {
        $this->relief = $relief;
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
        return $this->nomMiniscule ? $this->nomMiniscule . ' (' . $this->insee . ')'  : $this->nom . ' (' . $this->insee . ')';
    }
}

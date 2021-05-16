<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Terrain entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\TerrainRepository")
 * @ORM\Table()
 */
class Terrain
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
    private $relief;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $altitude;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $exposition;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $livraison;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="nom_poste", nullable=true)
     */
    private $nomPoste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="distance_pdl", nullable=true)
     */
    private $injection;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="document_urbanisme", nullable=true)
     */
    private $documentUrbanisme;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="etat_urbanisme", nullable=true)
     */
    private $etatUrbanisme;

    /**
     * @var array
     *
     * @ORM\Column(type="array", name="document_energie", nullable=true)
     */
    private $documentEnergie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="etat_energie", nullable=true)
     */
    private $etatEnergie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $zonage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pcaet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $tepos;

    private $eoliennes;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $vitesseVent;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $productibleSolaire;

    /**
     * @var Projet
     *
     * @ORM\OneToOne(targetEntity="Projet", mappedBy="terrain")
     */
    private $projet;

    public function __construct()
    {
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
    public function getRelief()
    {
        return $this->relief;
    }

    /**
     * @param string $relief
     * @return \AppBundle\Entity\Terrain
     */
    public function setRelief($relief)
    {
        $this->relief = $relief;
        return $this;
    }

    /**
     * @return string
     */
    public function getAltitude()
    {
        return $this->altitude;
    }

    /**
     * @param string $altitude
     * @return \AppBundle\Entity\Terrain
     */
    public function setAltitude($altitude)
    {
        $this->altitude = $altitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getExposition()
    {
        return $this->exposition;
    }

    /**
     *
     * @param string $exposition
     * @return \AppBundle\Entity\Terrain
     */
    public function setExposition($exposition)
    {
        $this->exposition = $exposition;
        return $this;
    }

    /**
     * @return string
     */
    public function getLivraison()
    {
        return $this->livraison;
    }

    /**
     *
     * @param string $livraison
     * @return \AppBundle\Entity\Terrain
     */
    public function setLivraison($livraison)
    {
        $this->livraison = $livraison;
        return $this;
    }

    /**
     * @return string
     */
    public function getNomPoste()
    {
        return $this->nomPoste;
    }

    /**
     *
     * @param string $nomPoste
     * @return \AppBundle\Entity\Terrain
     */
    public function setNomPoste($nomPoste)
    {
        $this->nomPoste = $nomPoste;
        return $this;
    }

    /**
     * @return string
     */
    public function getInjection()
    {
        return $this->injection;
    }

    /**
     *
     * @param string $injection
     * @return \AppBundle\Entity\Terrain
     */
    public function setInjection($injection)
    {
        $this->injection = $injection;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentUrbanisme()
    {
        return $this->documentUrbanisme;
    }

    /**
     *
     * @param string $documentUrbanisme
     * @return \AppBundle\Entity\Terrain
     */
    public function setDocumentUrbanisme($documentUrbanisme)
    {
        $this->documentUrbanisme = $documentUrbanisme;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtatUrbanisme()
    {
        return $this->etatUrbanisme;
    }

    /**
     *
     * @param string $etatUrbanisme
     * @return \AppBundle\Entity\Terrain
     */
    public function setEtatUrbanisme($etatUrbanisme)
    {
        $this->etatUrbanisme = $etatUrbanisme;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentEnergie()
    {
        return $this->documentEnergie;
    }

    /**
     *
     * @param string $documentEnergie
     * @return \AppBundle\Entity\Terrain
     */
    public function setDocumentEnergie($documentEnergie)
    {
        $this->documentEnergie = $documentEnergie;
        return $this;
    }

    /**
     * @return string
     */
    public function getEtatEnergie()
    {
        return $this->etatEnergie;
    }

    /**
     *
     * @param string $etatEnergie
     * @return \AppBundle\Entity\Terrain
     */
    public function setEtatEnergie($etatEnergie)
    {
        $this->etatEnergie = $etatEnergie;
        return $this;
    }

    /**
     * @return string
     */
    public function getZonage()
    {
        return $this->zonage;
    }

    /**
     *
     * @param string $zonage
     * @return \AppBundle\Entity\Terrain
     */
    public function setZonage($zonage)
    {
        $this->zonage = $zonage;
        return $this;
    }

    /**
     * @return string
     */
    public function getPcaet()
    {
        return $this->pcaet;
    }

    /**
     *
     * @param string $pcaet
     * @return \AppBundle\Entity\Terrain
     */
    public function setPcaet($pcaet)
    {
        $this->pcaet = $pcaet;
        return $this;
    }

    /**
     * @return string
     */
    public function getTepos()
    {
        return $this->tepos;
    }

    /**
     *
     * @param string $tepos
     * @return \AppBundle\Entity\Terrain
     */
    public function setTepos($tepos)
    {
        $this->tepos = $tepos;
        return $this;
    }

    /**
     * @return string
     */
    public function getEoliennes()
    {
        return $this->eoliennes;
    }

    /**
     *
     * @param string $eoliennes
     * @return \AppBundle\Entity\Terrain
     */
    public function setEoliennes($eoliennes)
    {
        $this->eoliennes = $eoliennes;
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
     *
     * @param string $vitesseVent
     * @return \AppBundle\Entity\Terrain
     */
    public function setVitesseVent($vitesseVent)
    {
        $this->vitesseVent = $vitesseVent;
        return $this;
    }

    /**
     * @return string
     */
    public function getProductibleSolaire()
    {
        return $this->productibleSolaire;
    }

    /**
     *
     * @param string $productibleSolaire
     * @return \AppBundle\Entity\Terrain
     */
    public function setProductibleSolaire($productibleSolaire)
    {
        $this->productibleSolaire = $productibleSolaire;
        return $this;
    }
    
    /**
     * @return array
     */
    public static function getReliefList()
    {
        return [
            'montagne' => 'Montagne',
            'plateau' => 'Plateau',
            'plaine' => 'Plaine',
            'valle' => 'Vallée',
            'littoral' => 'Littoral'
        ];
    }
    
    /**
     * @return array
     */
    public static function getDocumentUrbanismeList()
    {
        return [
            'plu' => 'PLU',
            'plui' => 'PLUi',
            'carte'=> 'CARTE',
            'pos' => 'POS'
        ];
    }
    
    /**
     * @return array
     */
    public static function getDocumentEnergieList()
    {
        return [
            'pcaet' => 'PCAET',
            'sraddet' => 'SRADDET',
            'srb' => 'SRB'
        ];
    }
    
    /**
     * @return array
     */
    public static function getEtatList()
    {
        return [
            'sans' => 'Sans',
            'prescrit' => 'Prescrit',
            'en_cours' => 'En cours',
            'en_projet' => 'En projet'
        ];
    }
    
    /**
     * @return array
     */
    public static function getZonageList()
    {
        return [
            'zone_urbanisee' => 'Zone urbanisée',
            'zone_naturelle' => 'Zone naturelle',
            'zone_agricole' => 'Zone agricole',
            'zone_a_urbaniser' => 'Zone à urbaniser',
            'zone_protegee' => 'Zone protégée',
            'zone_incontructible' => 'Zone incontructible',
            'zone_constructible' => 'Zone constructible'
        ];
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\Terrain
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    public function isNotEmpty()
    {
        if($this->relief || $this->altitude || $this->exposition || $this->livraison || $this->nomPoste || $this->injection || $this->zonage || $this->documentUrbanisme)
            return true;
        else return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->relief;
    }
}

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
    private $topographie;

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

    private $eoliennesDepartement;

    private $eoliennesCommune;

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
    private $productiblePv;

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
    public function getTopographie()
    {
        return $this->topographie;
    }

    /**
     * @param string $topographie
     * @return \AppBundle\Entity\Terrain
     */
    public function setTopographie($topographie)
    {
        $this->topographie = $topographie;
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
    public function getEoliennesDepartement()
    {
        return $this->eoliennesDepartement;
    }

    /**
     *
     * @param string $eoliennesDepartement
     * @return \AppBundle\Entity\Terrain
     */
    public function setEoliennesDepartement($eoliennesDepartement)
    {
        $this->eoliennesDepartement = $eoliennesDepartement;
        return $this;
    }

    /**
     * @return string
     */
    public function getEoliennesCommune()
    {
        return $this->eoliennesCommune;
    }

    /**
     *
     * @param string $eoliennesCommune
     * @return \AppBundle\Entity\Terrain
     */
    public function setEoliennesCommune($eoliennesCommune)
    {
        $this->eoliennesCommune = $eoliennesCommune;
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
    public function getProductiblePv()
    {
        return $this->productiblePv;
    }

    /**
     *
     * @param string $productiblePv
     * @return \AppBundle\Entity\Terrain
     */
    public function setProductiblePv($productiblePv)
    {
        $this->productiblePv = $productiblePv;
        return $this;
    }
    
    /**
     * @return array
     */
    public static function getTopographieList()
    {
        return [
            'Haute montagne' => 'Haute montagne',
            'Moyenne montagne' => 'Moyenne montagne',
            'Hauts plateaux' => 'Hauts plateaux',
            'Bas plateaux-colines' => 'Bas plateaux-colines',
            'Plaine' => 'Plaine',
            'Vallée' => 'Vallée',
            'Versant' => 'Versant'
        ];
    }
    
    /**
     * @return array
     */
    public static function getDocumentUrbanismeList()
    {
        return [
            'PLU' => 'PLU',
            'CARTE'=> 'CARTE',
            'POS' => 'POS',
            'SANS' => 'SANS'
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
            'Sans' => 'Sans',
            'Adopté' => 'Adopté',
            'A l\'étude' => 'A l\'étude',
            'En réflexion' => 'En réflexion'
        ];
    }
    
    /**
     * @return array
     */
    public static function getZonageList()
    {
        return [
            'zone_naturelle' => 'Zone naturelle',
            'zone_agricole' => 'Zone agricole',
            'zone_urbanisee' => 'Zone urbanisée',
            'zone_a_urbaniser' => 'Zone à urbaniser',
            'zone_a_risque' => 'Zone à risque',
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
        if($this->topographie || $this->altitude || $this->exposition || $this->livraison || $this->nomPoste || $this->injection || $this->zonage || $this->documentUrbanisme)
            return true;
        else return false;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->topographie;
    }
}

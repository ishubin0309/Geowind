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
    private $gestionnaire;

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
    private $distancePdl;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="document_opposable", nullable=true)
     */
    private $documentOpposable;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $zonage;

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
    public function getGestionnaire()
    {
        return $this->gestionnaire;
    }

    /**
     *
     * @param string $gestionnaire
     * @return \AppBundle\Entity\Terrain
     */
    public function setGestionnaire($gestionnaire)
    {
        $this->gestionnaire = $gestionnaire;
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
    public function getDistancePdl()
    {
        return $this->distancePdl;
    }

    /**
     *
     * @param string $distancePdl
     * @return \AppBundle\Entity\Terrain
     */
    public function setDistancePdl($distancePdl)
    {
        $this->distancePdl = $distancePdl;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentOpposable()
    {
        return $this->documentOpposable;
    }

    /**
     *
     * @param string $documentOpposable
     * @return \AppBundle\Entity\Terrain
     */
    public function setDocumentOpposable($documentOpposable)
    {
        $this->documentOpposable = $documentOpposable;
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
     * @return array
     */
    public static function getTopographieList()
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
    public static function getDocumentOpposableList()
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

    /**
     * @return string
     */
    /* public function __toString()
    {
        return $this->topographie;
        return $this->altitude;
        return $this->exposition;
        return $this->gestionnaire;
        return $this->nomPoste;
        return $this->distancePdl;
        return $this->documentOpposable;
        return $this->zonage;
    } */
}

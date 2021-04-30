<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use JsonSerializable;

/**
 * Toiture entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ToitureRepository")
 * @Vich\Uploadable
 */
class Toiture implements JsonSerializable
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
     * @ORM\Column(type="string", name="nom", nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="exposition", nullable=true)
     */
    private $exposition;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="haut_pente", nullable=true)
     */
    private $hautPente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="bas_pente", nullable=true)
     */
    private $basPente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="pente", nullable=true)
     */
    private $pente;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="longueur", nullable=true)
     */
    private $longueur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="largeur", nullable=true)
     */
    private $largeur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="surface_totale", nullable=true)
     */
    private $surfaceTotale;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="surface_utile", nullable=true)
     */
    private $surfaceUtile;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="entraxe", nullable=true)
     */
    private $entraxe;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photoOriginalName = 'photo';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff", fileNameProperty="photo")
     */
    private $photoFile;

    /**
     * @var Batiment
     *
     * @ORM\ManyToOne(targetEntity="Batiment", inversedBy="toitures")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $batimentExistant;

    /**
     * @var Batiment
     *
     * @ORM\ManyToOne(targetEntity="BatimentNouveau", inversedBy="toitures")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $batimentNouveau;

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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return \AppBundle\Entity\Toiture
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
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
     * @param string $exposition
     * @return \AppBundle\Entity\Toiture
     */
    public function setExposition($exposition)
    {
        $this->exposition = $exposition;
        return $this;
    }

    /**
     * @return string
     */
    public function getHautPente()
    {
        return $this->hautPente;
    }

    /**
     * @param string $hautPente
     * @return \AppBundle\Entity\Toiture
     */
    public function setHautPente($hautPente)
    {
        $this->hautPente = $hautPente;
        return $this;
    }

    /**
     * @return string
     */
    public function getBasPente()
    {
        return $this->basPente;
    }

    /**
     * @param string $basPente
     * @return \AppBundle\Entity\Toiture
     */
    public function setBasPente($basPente)
    {
        $this->basPente = $basPente;
        return $this;
    }

    /**
     * @return string
     */
    public function getPente()
    {
        return $this->pente;
    }

    /**
     * @param string $pente
     * @return \AppBundle\Entity\Toiture
     */
    public function setPente($pente)
    {
        $this->pente = $pente;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongueur()
    {
        return $this->longueur;
    }

    /**
     * @param string $longueur
     * @return \AppBundle\Entity\Toiture
     */
    public function setLongueur($longueur)
    {
        $this->longueur = $longueur;
        return $this;
    }

    /**
     * @return string
     */
    public function getLargeur()
    {
        return $this->largeur;
    }

    /**
     * @param string $largeur
     * @return \AppBundle\Entity\Toiture
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceTotale()
    {
        return $this->surfaceTotale;
    }

    /**
     * @param string $surfaceTotale
     * @return \AppBundle\Entity\Toiture
     */
    public function setSurfaceTotale($surfaceTotale)
    {
        $this->surfaceTotale = $surfaceTotale;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceUtile()
    {
        return $this->surfaceUtile;
    }

    /**
     * @param string $surfaceUtile
     * @return \AppBundle\Entity\Toiture
     */
    public function setSurfaceUtile($surfaceUtile)
    {
        $this->surfaceUtile = $surfaceUtile;
        return $this;
    }

    /**
     * @return string
     */
    public function getEntraxe()
    {
        return $this->entraxe;
    }

    /**
     * @param string $entraxe
     * @return \AppBundle\Entity\Toiture
     */
    public function setEntraxe($entraxe)
    {
        $this->entraxe = $entraxe;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto()
    {
        return $this->photo;
    }

    /**
     *
     * @param string $photo
     * @return \AppBundle\Entity\Toiture
     */
    public function setPhoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhotoFile()
    {
        return $this->photoFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo
     *
     * @return $this
     */
    public function setPhotoFile(File $photo = null)
    {
        $this->photoFile = $photo;
        if ($photo) {
            if ($photo instanceof UploadedFile) {
                $this->photoOriginalName = $photo->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoOriginalName()
    {
        return $this->photoOriginalName;
    }

    /**
     * @param string $photoOriginalName
     * @return \AppBundle\Entity\Toiture
     */
    public function setPhotoOriginalName($photoOriginalName)
    {
        $this->photoOriginalName = $photoOriginalName;
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
     * @return \AppBundle\Entity\Toiture
     */
    public function setGestionnaire($gestionnaire)
    {
        $this->gestionnaire = $gestionnaire;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceOnduleur()
    {
        return $this->distanceOnduleur;
    }

    /**
     *
     * @param string $distanceOnduleur
     * @return \AppBundle\Entity\Toiture
     */
    public function setDistanceOnduleur($distanceOnduleur)
    {
        $this->distanceOnduleur = $distanceOnduleur;
        return $this;
    }

    /**
     * @return string
     */
    public function getDistanceTranfo()
    {
        return $this->distanceTranfo;
    }

    /**
     *
     * @param string $distanceTranfo
     * @return \AppBundle\Entity\Toiture
     */
    public function setDistanceTranfo($distanceTranfo)
    {
        $this->distanceTranfo = $distanceTranfo;
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
     * @return \AppBundle\Entity\Toiture
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
     * @return \AppBundle\Entity\Toiture
     */
    public function setZonage($zonage)
    {
        $this->zonage = $zonage;
        return $this;
    }

    /**
     * @return Batiment
     */
    public function getBatimentExistant()
    {
        return $this->batimentExistant;
    }

    /**
     * @param Batiment $batimentExistant
     * @return \AppBundle\Entity\Toiture
     */
    public function setBatimentExistant(Batiment $batimentExistant)
    {
        $this->batimentExistant = $batimentExistant;
        return $this;
    }

    /**
     * @return Batiment
     */
    public function getBatimentNouveau()
    {
        return $this->batimentNouveau;
    }

    /**
     * @param Batiment $batimentNouveau
     * @return \AppBundle\Entity\Toiture
     */
    public function setBatimentNouveau(BatimentNouveau $batimentNouveau)
    {
        $this->batimentNouveau = $batimentNouveau;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }

    public function jsonSerialize()
    {
        return array(
            'nom' => $this->nom,
            'exposition'=> $this->exposition,
            'hautPente'=> $this->hautPente,
            'basPente'=> $this->basPente,
            'pente'=> $this->pente,
            'longueur'=> $this->longueur,
            'largeur'=> $this->largeur,
            'surfaceTotale'=> $this->surfaceTotale,
            'surfaceUtile'=> $this->surfaceUtile,
            'entraxe'=> $this->entraxe,
            'photo'=> $this->photo,
        );
    }
}

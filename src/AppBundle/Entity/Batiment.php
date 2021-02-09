<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Batiment entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BatimentRepository")
 * @Vich\Uploadable
 */
class Batiment
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
    private $pans;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $longeur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $largeur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $faitage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="surface_sol", nullable=true)
     */
    private $surfaceSol;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $charge;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $couverture;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $bardage;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $ossature;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $charpente;

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
     * @var string
     *
     * @ORM\Column(type="string", name="gestionnaire", nullable=true)
     */
    private $gestionnaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="distance_onduleur", nullable=true)
     */
    private $distanceOnduleur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="distance_tranfo", nullable=true)
     */
    private $distanceTranfo;

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
     * @var ArrayCollection|Toiture[]
     *
     * @ORM\OneToMany(targetEntity="Toiture", mappedBy="batimentExistant", cascade={"all"}, orphanRemoval=true)
     */
    private $toitures;

    /**
     * @var Projet
     *
     * @ORM\OneToOne(targetEntity="Projet", mappedBy="batimentExistant")
     */
    private $projet;

    public function __construct()
    {
        $this->toitures = new ArrayCollection();
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
    public function getPans()
    {
        return $this->pans;
    }

    /**
     * @param string $pans
     * @return \AppBundle\Entity\Batiment
     */
    public function setPans($pans)
    {
        $this->pans = $pans;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongeur()
    {
        return $this->longeur;
    }

    /**
     * @param string $longeur
     * @return \AppBundle\Entity\Batiment
     */
    public function setLongeur($longeur)
    {
        $this->longeur = $longeur;
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
     *
     * @param string $largeur
     * @return \AppBundle\Entity\Batiment
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * @return string
     */
    public function getFaitage()
    {
        return $this->faitage;
    }

    /**
     *
     * @param string $faitage
     * @return \AppBundle\Entity\Batiment
     */
    public function setFaitage($faitage)
    {
        $this->faitage = $faitage;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurfaceSol()
    {
        return $this->surfaceSol;
    }

    /**
     *
     * @param string $surfaceSol
     * @return \AppBundle\Entity\Batiment
     */
    public function setSurfaceSol($surfaceSol)
    {
        $this->surfaceSol = $surfaceSol;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     *
     * @param string $charge
     * @return \AppBundle\Entity\Batiment
     */
    public function setCharge($charge)
    {
        $this->charge = $charge;
        return $this;
    }

    /**
     * @return string
     */
    public function getCouverture()
    {
        return $this->couverture;
    }

    /**
     *
     * @param string $couverture
     * @return \AppBundle\Entity\Batiment
     */
    public function setCouverture($couverture)
    {
        $this->couverture = $couverture;
        return $this;
    }

    /**
     * @return string
     */
    public function getBardage()
    {
        return $this->bardage;
    }

    /**
     *
     * @param string $bardage
     * @return \AppBundle\Entity\Batiment
     */
    public function setBardage($bardage)
    {
        $this->bardage = $bardage;
        return $this;
    }

    /**
     * @return string
     */
    public function getOssature()
    {
        return $this->ossature;
    }

    /**
     *
     * @param string $ossature
     * @return \AppBundle\Entity\Batiment
     */
    public function setOssature($ossature)
    {
        $this->ossature = $ossature;
        return $this;
    }

    /**
     * @return string
     */
    public function getCharpente()
    {
        return $this->charpente;
    }

    /**
     *
     * @param string $charpente
     * @return \AppBundle\Entity\Batiment
     */
    public function setCharpente($charpente)
    {
        $this->charpente = $charpente;
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
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
     * @return \AppBundle\Entity\Batiment
     */
    public function setZonage($zonage)
    {
        $this->zonage = $zonage;
        return $this;
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @return ArrayCollection|Toiture[]
     */
    public function getToitures()
    {
        return $this->toitures;
    }

    /**
     * @param ArrayCollection $toitures
     * @return \AppBundle\Entity\Batiment
     */
    public function setToitures(ArrayCollection $toitures)
    {
        $this->toitures = $toitures;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Toiture $toiture
     */
    public function addToiture(Toiture $toiture)
    {
        if (!$this->toitures->contains($toiture)) {
            $toiture->setBatimentExistant($this);
            $this->toitures->add($toiture);
        }
    }

    /**
     * @param \AppBundle\Entity\Toiture $toiture
     */
    public function removeToiture(Toiture $toiture)
    {
        $this->toitures->removeElement($toiture);
    }
    
    /**
     * @return array
     */
    public static function getChargeList()
    {
        return [
            'verifier' => 'Vérifier',
            'solide'=> 'Solide',
            'faible'=> 'Faible'
        ];
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\Batiment
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom ? $this->nom : 'Modèle'.$this->id;
    }
}

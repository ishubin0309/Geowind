<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * BatimentNouveau entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BatimentNouveauRepository")
 * @UniqueEntity("nom")
 * @Vich\Uploadable
 */
class BatimentNouveau
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
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     */
    private $nom;

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
    private $structure;

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
    private $note;

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
     * @ORM\OneToMany(targetEntity="Toiture", mappedBy="batimentNouveau", cascade={"all"}, orphanRemoval=true)
     */
    private $toitures;

    /**
     * @var Departement
     *
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="batimentNouveau", cascade={"persist"})
     */
    private $projets;

    public function __construct()
    {
        $this->toitures = new ArrayCollection();
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
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setSurfaceSol($surfaceSol)
    {
        $this->surfaceSol = $surfaceSol;
        return $this;
    }

    /**
     * @return string
     */
    public function getStructure()
    {
        return $this->structure;
    }

    /**
     *
     * @param string $structure
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setStructure($structure)
    {
        $this->structure = $structure;
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setCharpente($charpente)
    {
        $this->charpente = $charpente;
        return $this;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     *
     * @param string $note
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setNote($note)
    {
        $this->note = $note;
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
     * @return \AppBundle\Entity\BatimentNouveau
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
            $toiture->setBatimentNouveau($this);
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
     * @return ArrayCollection|Projet[]
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * @param ArrayCollection $projets
     * @return \AppBundle\Entity\Projet
     */
    public function setProjets(ArrayCollection $projets)
    {
        $this->projets = $projets;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Projet $projet
     */
    public function addProjet(Projet $projet)
    {
        if (!$this->projets->contains($projet)) {
            $projet->setBatimentNouveau($this);
            $this->projets->add($projet);
        }
    }

    /**
     * @param \AppBundle\Entity\Projet $projet
     */
    public function removeProjet(Projet $projet)
    {
        $this->projets->removeElement($projet);
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\BatimentNouveau
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

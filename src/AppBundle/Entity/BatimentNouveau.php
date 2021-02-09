<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use JsonSerializable;

/**
 * BatimentNouveau entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BatimentNouveauRepository")
 * @UniqueEntity("nom")
 * @Vich\Uploadable
 */
class BatimentNouveau implements JsonSerializable
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
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo2;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo2OriginalName = 'photo2';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff2", fileNameProperty="photo2")
     */
    private $photo2File;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo3;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo3OriginalName = 'photo3';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff3", fileNameProperty="photo3")
     */
    private $photo3File;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo4;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photo4OriginalName = 'photo4';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff4", fileNameProperty="photo4")
     */
    private $photo4File;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="description", nullable=true)
     */
    private $description;

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
    public function getCharge()
    {
        return $this->charge;
    }

    /**
     *
     * @param string $charge
     * @return \AppBundle\Entity\BatimentNouveau
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
    public function getPhoto2()
    {
        return $this->photo2;
    }

    /**
     *
     * @param string $photo2
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto2($photo2)
    {
        $this->photo2 = $photo2;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhoto2File()
    {
        return $this->photo2File;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo2
     *
     * @return $this
     */
    public function setPhoto2File(File $photo2 = null)
    {
        $this->photo2File = $photo2;
        if ($photo2) {
            if ($photo2 instanceof UploadedFile) {
                $this->photo2OriginalName = $photo2->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto2OriginalName()
    {
        return $this->photo2OriginalName;
    }

    /**
     * @param string $photo2OriginalName
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto2OriginalName($photo2OriginalName)
    {
        $this->photo2OriginalName = $photo2OriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto3()
    {
        return $this->photo3;
    }

    /**
     *
     * @param string $photo3
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto3($photo3)
    {
        $this->photo3 = $photo3;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhoto3File()
    {
        return $this->photo3File;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo3
     *
     * @return $this
     */
    public function setPhoto3File(File $photo3 = null)
    {
        $this->photo3File = $photo3;
        if ($photo3) {
            if ($photo3 instanceof UploadedFile) {
                $this->photo3OriginalName = $photo3->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto3OriginalName()
    {
        return $this->photo3OriginalName;
    }

    /**
     * @param string $photo3OriginalName
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto3OriginalName($photo3OriginalName)
    {
        $this->photo3OriginalName = $photo3OriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto4()
    {
        return $this->photo4;
    }

    /**
     *
     * @param string $photo4
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto4($photo4)
    {
        $this->photo4 = $photo4;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhoto4File()
    {
        return $this->photo4File;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photo4
     *
     * @return $this
     */
    public function setPhoto4File(File $photo4 = null)
    {
        $this->photo4File = $photo4;
        if ($photo4) {
            if ($photo4 instanceof UploadedFile) {
                $this->photo4OriginalName = $photo4->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhoto4OriginalName()
    {
        return $this->photo4OriginalName;
    }

    /**
     * @param string $photo4OriginalName
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setPhoto4OriginalName($photo4OriginalName)
    {
        $this->photo4OriginalName = $photo4OriginalName;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     *
     * @param string $description
     * @return \AppBundle\Entity\BatimentNouveau
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
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
     * @return string
     */
    public function __toString()
    {
        return $this->nom ? $this->nom : 'Modèle'.$this->id;
    }

    public function jsonSerialize()
    {
        $toitures = [];
        foreach($this->toitures as $toiture) $toitures[] = $toiture;
        return array(
            'id' => $this->id,
            'nom' => $this->nom,
            'pans'=> $this->pans,
            'longeur'=> $this->longeur,
            'largeur'=> $this->largeur,
            'faitage'=> $this->faitage,
            'surfaceSol'=> $this->surfaceSol,
            'charge'=> $this->charge,
            'photo'=> $this->photo,
            'photo2'=> $this->photo2,
            'photo3'=> $this->photo3,
            'photo4'=> $this->photo4,
            'bardage'=> explode(',', $this->bardage),
            'ossature'=> explode(',', $this->ossature),
            'charpente'=> explode(',', $this->charpente),
            'couverture'=> explode(',', $this->couverture),
            'toitures'=> $toitures,
        );
    }
}

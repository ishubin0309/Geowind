<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Liste entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ListeRepository")
 * @Vich\Uploadable
 */
class Liste
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
    private $liste;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true, nullable=true)
     */
    private $listeOriginalName = 'Sans liste';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="document", fileNameProperty="liste")
     */
    private $listeFile;

    /**
     * @var ArrayCollection|Projet[]
     *
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="liste", cascade={"all"}, orphanRemoval=true)
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
    public function getListe()
    {
        return $this->liste;
    }

    /**
     *
     * @param string $liste
     * @return \AppBundle\Entity\Liste
     */
    public function setListe($liste)
    {
        $this->liste = $liste;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getListeFile()
    {
        return $this->listeFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $liste
     *
     * @return $this
     */
    public function setListeFile(File $liste = null)
    {
        $this->listeFile = $liste;
        if ($liste) {
            if ($liste instanceof UploadedFile) {
                $this->listeOriginalName = $liste->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getListeOriginalName()
    {
        return $this->listeOriginalName;
    }

    /**
     * @param string $listeOriginalName
     * @return \AppBundle\Entity\Liste
     */
    public function setListeOriginalName($listeOriginalName)
    {
        $this->listeOriginalName = $listeOriginalName;
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
     * @return ArrayCollection|Projet[]
     */
    public function getProjets()
    {
        return $this->projets;
    }

    /**
     * @param ArrayCollection $projets
     * @return \AppBundle\Entity\Batiment
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
            $projet->setListe($this);
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
        return $this->listeOriginalName;
    }
}

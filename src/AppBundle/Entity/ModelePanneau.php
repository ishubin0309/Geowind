<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use JsonSerializable;

/**
 * ModelePanneau entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @UniqueEntity(fields={"nom", "technique"})
 */
class ModelePanneau implements JsonSerializable
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
     * @Assert\NotBlank()
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $marque;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $pays;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $technique;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="puissance_min", nullable=true)
     */
    private $puissanceMin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="puissance_max", nullable=true)
     */
    private $puissanceMax;

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
    private $epaisseur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $poids;

    /**
     * @var Departement
     *
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="modelePanneau", cascade={"persist"})
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
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getMarque()
    {
        return $this->marque;
    }

    /**
     * @param string $marque
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setMarque($marque)
    {
        $this->marque = $marque;
        return $this;
    }

    /**
     * @return string
     */
    public function getPays()
    {
        return $this->pays;
    }

    /**
     * @param string $pays
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
        return $this;
    }

    /**
     * @return string
     */
    public function getTechnique()
    {
        return $this->technique;
    }

    /**
     *
     * @param string $technique
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setTechnique($technique)
    {
        $this->technique = $technique;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissanceMin()
    {
        return $this->puissanceMin;
    }

    /**
     *
     * @param string $puissanceMin
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPuissanceMin($puissanceMin)
    {
        $this->puissanceMin = $puissanceMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getPuissanceMax()
    {
        return $this->puissanceMax;
    }

    /**
     *
     * @param string $puissanceMax
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPuissanceMax($puissanceMax)
    {
        $this->puissanceMax = $puissanceMax;
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
     *
     * @param string $longeur
     * @return \AppBundle\Entity\ModelePanneau
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
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setLargeur($largeur)
    {
        $this->largeur = $largeur;
        return $this;
    }

    /**
     * @return string
     */
    public function getEpaisseur()
    {
        return $this->epaisseur;
    }

    /**
     *
     * @param string $epaisseur
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setEpaisseur($epaisseur)
    {
        $this->epaisseur = $epaisseur;
        return $this;
    }

    /**
     * @return string
     */
    public function getPoids()
    {
        return $this->poids;
    }

    /**
     *
     * @param string $poids
     * @return \AppBundle\Entity\ModelePanneau
     */
    public function setPoids($poids)
    {
        $this->poids = $poids;
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
            $projet->setModelePanneau($this);
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

    public function cloneThis(ModelePanneau $modelePanneau)
    {
        $this->nom = $modelePanneau->getNom();
        $this->marque = $modelePanneau->getMarque();
        $this->technique = $modelePanneau->getTechnique();
        $this->pays = $modelePanneau->getPays();
        $this->puissanceMin = $modelePanneau->getPuissanceMin();
        $this->puissanceMax = $modelePanneau->getPuissanceMax();
        $this->longeur = $modelePanneau->getLongeur();
        $this->largeur = $modelePanneau->getLargeur();
        $this->epaisseur = $modelePanneau->getEpaisseur();
        $this->poids = $modelePanneau->getPoids();
    }

    public function jsonSerialize()
    {
        return array(
            // 'id' => $this->id,
            'Modèle' => $this->nom,
            'Marque'=> $this->marque,
            'Pays'=> $this->pays,
            'Technique'=> $this->technique,
            'Puissance (Wc)'=> $this->puissanceMin . ',' . $this->puissanceMax,
            // 'Puissance max (Wc)'=> $this->puissanceMax,
            'Longeur (mm)'=> $this->longeur,
            'Epaisseur (mm)'=> $this->epaisseur,
            'Poids (kg)'=> $this->poids,
        );
    }
}

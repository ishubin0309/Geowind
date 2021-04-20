<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\File;
use JsonSerializable;

/**
 * ModeleEolienne entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @UniqueEntity("nom")
 */
class ModeleEolienne implements JsonSerializable
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
     * @ORM\Column(type="string", name="hauteur_mat_min", nullable=true)
     */
    private $hauteurMatMin;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="hauteur_mat_max", nullable=true)
     */
    private $hauteurMatMax;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="diametre_rotor", nullable=true)
     */
    private $diametreRotor;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="hauteur_totale", nullable=true)
     */
    private $hauteurTotale;

    /**
     * @var Departement
     *
     * @ORM\OneToMany(targetEntity="Projet", mappedBy="modeleEolienne", cascade={"persist"})
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
     * @return \AppBundle\Entity\ModeleEolienne
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
     * @return \AppBundle\Entity\ModeleEolienne
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
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setPays($pays)
    {
        $this->pays = $pays;
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
     * @return \AppBundle\Entity\ModeleEolienne
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
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setPuissanceMax($puissanceMax)
    {
        $this->puissanceMax = $puissanceMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getHauteurMatMin()
    {
        return $this->hauteurMatMin;
    }

    /**
     *
     * @param string $hauteurMatMin
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setHauteurMatMin($hauteurMatMin)
    {
        $this->hauteurMatMin = $hauteurMatMin;
        return $this;
    }

    /**
     * @return string
     */
    public function getHauteurMatMax()
    {
        return $this->hauteurMatMax;
    }

    /**
     *
     * @param string $hauteurMatMax
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setHauteurMatMax($hauteurMatMax)
    {
        $this->hauteurMatMax = $hauteurMatMax;
        return $this;
    }

    /**
     * @return string
     */
    public function getDiametreRotor()
    {
        return $this->diametreRotor;
    }

    /**
     *
     * @param string $diametreRotor
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setDiametreRotor($diametreRotor)
    {
        $this->diametreRotor = $diametreRotor;
        return $this;
    }

    /**
     * @return string
     */
    public function getHauteurTotale()
    {
        return $this->hauteurTotale;
    }

    /**
     *
     * @param string $hauteurTotale
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setHauteurTotale($hauteurTotale)
    {
        $this->hauteurTotale = $hauteurTotale;
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
            $projet->setModeleEolienne($this);
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
        return array(
            // 'id' => $this->id,
            'Modèle' => $this->nom,
            'Fabriquant'=> $this->marque,
            'Origine'=> $this->pays,
            'Puissance min (Mw)'=> $this->puissanceMin,
            'Puissance max (Mw)'=> $this->puissanceMax,
            'Hauteur mât (m)'=> $this->hauteurMatMin . ', ' . $this->hauteurMatMax,
            'Diamètre rotor (m)'=> $this->diametreRotor,
            'Hauteur totale (m)'=> $this->hauteurTotale,
        );
    }
}

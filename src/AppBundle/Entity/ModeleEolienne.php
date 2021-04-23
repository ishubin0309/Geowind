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
 * @UniqueEntity(fields={"nom", "hauteurMat"})
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
     * @ORM\Column(type="string", name="puissance", nullable=true)
     */
    private $puissance;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="hauteur_mat", nullable=true)
     */
    private $hauteurMat;

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
    public function getPuissance()
    {
        return $this->puissance;
    }

    /**
     *
     * @param string $puissance
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setPuissance($puissance)
    {
        $this->puissance = $puissance;
        return $this;
    }

    /**
     * @return string
     */
    public function getHauteurMat()
    {
        return $this->hauteurMat;
    }

    /**
     *
     * @param string $hauteurMat
     * @return \AppBundle\Entity\ModeleEolienne
     */
    public function setHauteurMat($hauteurMat)
    {
        $this->hauteurMat = $hauteurMat;
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

    public function cloneThis(ModeleEolienne $modeleEolienne)
    {
        $this->nom = $modeleEolienne->getNom();
        $this->marque = $modeleEolienne->getMarque();
        $this->pays = $modeleEolienne->getPays();
        $this->puissance = $modeleEolienne->getPuissance();
        $this->hauteurMat = $modeleEolienne->getHauteurMat();
        $this->diametreRotor = $modeleEolienne->getDiametreRotor();
        $this->hauteurTotale = $modeleEolienne->getHauteurTotale();
    }

    public function jsonSerialize()
    {
        return array(
            // 'id' => $this->id,
            'Modèle' => $this->nom . ' ('.$this->hauteurMat.'m)',
            'Fabriquant'=> $this->marque,
            'Origine'=> $this->pays,
            'Puissance <span style="color:red;">(Mw)</span>'=> $this->puissance,
            'Hauteur mât <span style="color:red;">(m)</span>'=> $this->hauteurMat,
            'Diamètre rotor <span style="color:red;">(m)</span>'=> $this->diametreRotor,
            'Hauteur totale <span style="color:red;">(m)</span>'=> $this->hauteurTotale,
        );
    }
}

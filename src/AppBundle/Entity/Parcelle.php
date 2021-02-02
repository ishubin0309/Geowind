<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Parcelle entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParcelleRepository")
 * @ORM\Table()
 */
class Parcelle
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
    private $nom;

    /**
     * @var Departement
     *
     * @ORM\OneToOne(targetEntity="Departement")
     */
    private $departement;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $commune;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $lieuDit;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $surface;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;


    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="parcelles")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
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
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return \AppBundle\Entity\Parcelle
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param Departement $departement
     * @return \AppBundle\Entity\Parcelle
     */
    public function setDepartement(Departement $departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @param string $commune
     * @return \AppBundle\Entity\Parcelle
     */
    public function setCommune($commune)
    {
        $this->commune = $commune;
        return $this;
    }

    /**
     * @return string
     */
    public function getLieuDit()
    {
        return $this->lieuDit;
    }

    /**
     *
     * @param string $lieuDit
     * @return \AppBundle\Entity\Parcelle
     */
    public function setLieuDit($lieuDit)
    {
        $this->lieuDit = $lieuDit;
        return $this;
    }

    /**
     * @return string
     */
    public function getSurface()
    {
        return $this->surface;
    }

    /**
     *
     * @param string $surface
     * @return \AppBundle\Entity\Parcelle
     */
    public function setSurface($surface)
    {
        $this->surface = $surface;
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
     * @return \AppBundle\Entity\Parcelle
     */
    public function setNote($note)
    {
        $this->note = $note;
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
     * @param Projet $projet
     * @return \AppBundle\Entity\Parcelle
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
        return 'Parcelle';
    }
}

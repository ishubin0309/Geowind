<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;

/**
 * Entité Bureau
 *
 * Représente un bureau d'études
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity
 * @UniqueEntity("nom")
 */
class Bureau
{
    use BlameableTrait;
    use TimestampableTrait;

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
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $representant;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresse;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $details;

    /**
     * @var ArrayCollection|Finance[]
     *
     * @ORM\OneToMany(targetEntity="Finance", mappedBy="bureau")
     * @ORM\OrderBy({"dateEngmt" = "ASC"})
     */
    private $finances;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->finances = new ArrayCollection();
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

    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getDetails()
    {
        return $this->details;
    }

    /**
     * @param string $details
     * @return \AppBundle\Entity\Bureau
     */
    public function setDetails($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * @return string
     */
    public function getRepresentant()
    {
        return $this->representant;
    }

    /**
     * @param string $representant
     * @return \AppBundle\Entity\Bureau
     */
    public function setRepresentant($representant)
    {
        $this->representant = $representant;
        return $this;
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * @param string $telephone
     * @return \AppBundle\Entity\Bureau
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return \AppBundle\Entity\Bureau
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return \AppBundle\Entity\Bureau
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return ArrayCollection|Finance[]
     */
    public function getFinances()
    {
        return $this->finances;
    }

    /**
     * @param ArrayCollection $finances
     * @return \AppBundle\Entity\Bureau
     */
    public function setFinances(ArrayCollection $finances)
    {
        $this->finances = $finances;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->nom;
    }
}

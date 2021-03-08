<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Departement entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DepartementRepository")
 */
class Departement
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
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=20, scale=16)
     */
    private $latitude = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=20, scale=16)
     */
    private $longitude = 0;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region")
     */
    private $region;

    /**
     * @var ArrayCollection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="departements")
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
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
     * @return \AppBundle\Entity\Region
     */
    public function setNom($nom)
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return \AppBundle\Entity\Region
     */
    public function setCode($code)
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return (float) $this->latitude;
    }

    /**
     * @param string $latitude
     * @return \AppBundle\Entity\Projet
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return (float) $this->longitude;
    }

    /**
     * @param string $longitude
     * @return \AppBundle\Entity\Projet
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * @return Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * @param Region $region
     * @return \AppBundle\Entity\Departement
     */
    public function setRegion(Region $region)
    {
        $this->region = $region;
        return $this;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * @param ArrayCollection $users
     * @return \AppBundle\Entity\Departement
     */
    public function setUsers(ArrayCollection $users)
    {
        $this->users = $users;
        return $this;
    }

    public function __toString()
    {
        return $this->nom . ' ('.$this->code.')';
    }
}

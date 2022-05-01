<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entité Géstionnaire
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\GestionnaireRepository")
 */
class Gestionnaire
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
     * @var Departement
     * 
     * @ORM\ManyToOne(targetEntity="Departement", inversedBy="gestionnaires")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $departement;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="gestionnaire")
     */
    private $gestionnaire;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="competence")
     */
    private $competence;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="contact")
     */
    private $contact;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="fonction")
     */
    private $fonction;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="adresse")
     */
    private $adresse;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="ville")
     */
    private $ville;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="email")
     */
    private $email;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", name="telephone", nullable=true)
     */
    private $telephone;

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->object;
    }
    
    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }
    
    public function getGestionnaire()
    {
        return $this->gestionnaire;
    }

    public function setGestionnaire($gestionnaire)
    {
        $this->gestionnaire = $gestionnaire;
        return $this;
    }

    public function getCompetence()
    {
        return $this->competence;
    }

    public function setCompetence($competence)
    {
        $this->competence = $competence;
        return $this;
    }

    public function getContact()
    {
        return $this->contact;
    }

    public function setContact($contact)
    {
        $this->contact = $contact;
        return $this;
    }

    public function getFonction()
    {
        return $this->fonction;
    }

    public function setFonction($fonction)
    {
        $this->fonction = $fonction;
        return $this;
    }

    public function getAdresse()
    {
        return $this->adresse;
    }

    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
        return $this;
    }

    public function getVille()
    {
        return $this->ville;
    }

    public function setVille($ville)
    {
        $this->ville = $ville;
        return $this;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    public function getTelephone()
    {
        return $this->telephone;
    }

    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;
        return $this;
    }
    
    public function getDepartement()
    {
        return $this->departement;
    }

    public function setDepartement(Departement $departement)
    {
        $this->departement = $departement;
        return $this;
    }
}

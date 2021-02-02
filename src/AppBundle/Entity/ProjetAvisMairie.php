<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProjetAvisMairie
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
     * @var Commune
     *
     * @ORM\ManyToOne(targetEntity="Commune")
     */
    private $commune;

    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="avisMairies")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $projet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $avisMairie;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Commune
     */
    public function getCommune()
    {
        return $this->commune;
    }

    /**
     * @param \AppBundle\Entity\Commune $commune
     * @return \AppBundle\Entity\AvisMairie
     */
    public function setCommune(Commune $commune)
    {
        $this->commune = $commune;
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
     * @return \AppBundle\Entity\ProjetAvisMairie
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    /**
     * @return string
     */
    public function getAvisMairie()
    {
        return $this->avisMairie;
    }

    /**
     * @param string $avisMairie
     * @return \AppBundle\Entity\ProjetAvisMairie
     */
    public function setAvisMairie($avisMairie)
    {
        $this->avisMairie = $avisMairie;
        return $this;
    }
}

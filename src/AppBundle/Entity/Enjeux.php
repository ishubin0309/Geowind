<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Enjeux entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\EnjeuxRepository")
 * @ORM\Table()
 */
class Enjeux
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
     */
    private $facteur;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $enjeux;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $risque;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="enjeuxs")
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
    public function getFacteur()
    {
        return $this->facteur;
    }

    /**
     * @param string $facteur
     * @return \AppBundle\Entity\Enjeux
     */
    public function setFacteur($facteur)
    {
        $this->facteur = $facteur;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnjeux()
    {
        return $this->enjeux;
    }

    /**
     * @param string $enjeux
     * @return \AppBundle\Entity\Enjeux
     */
    public function setEnjeux($enjeux)
    {
        $this->enjeux = $enjeux;
        return $this;
    }

    /**
     * @return string
     */
    public function getRisque()
    {
        return $this->risque;
    }

    /**
     *
     * @param string $risque
     * @return \AppBundle\Entity\Enjeux
     */
    public function setRisque($risque)
    {
        $this->risque = $risque;
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
     * @return \AppBundle\Entity\Enjeux
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return array
     */
    public static function getFacteurList()
    {
        return [
            'mairie' => 'Mairie',
            'epci' => 'EPCI',
            'habitations' => 'Habitations',
            'environnement' => 'Environnement',
            'monuments' => 'Monuments',
            'paysages' => 'Paysages',
            'saturation' => 'Saturation',
            'urbanisme' => 'Urbanisme',
            'servitudes' => 'Servitudes',
            'raccordement' => 'Raccordement',
            'structure' => 'Structure',
            'potentiel' => 'Potentiel',
            'gisement' => 'Gisement',
            'servitudes' => 'Servitudes',
            'echeance' => 'Echéances'
        ];
    }
    public static function getFacteurType($facteur)
    {
        $types = self::getFacteurList();
        return array_search($facteur, $types) ? array_search($facteur, $types) : strtolower($facteur);
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
     * @return \AppBundle\Entity\Enjeux
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
        return 'Facteur';
    }
}

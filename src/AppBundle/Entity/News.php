<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * News entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class News
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
    private $saisie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $theme;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $filiere;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $note;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $url;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateSaisie;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateParution;

    public function __construct()
    {
        $this->dateSaisie = new DateTime('today');
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
    public function getSaisie()
    {
        return $this->saisie;
    }

    /**
     * @param string $saisie
     * @return \AppBundle\Entity\News
     */
    public function setSaisie($saisie)
    {
        $this->saisie = $saisie;
        return $this;
    }

    /**
     * @return string
     */
    public function getTheme()
    {
        return $this->theme;
    }

    /**
     * @param string $theme
     * @return \AppBundle\Entity\News
     */
    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    /**
     * @return array
     */
    public static function getThemeList()
    {
        return [
            'Chiffres' => 'Chiffres',
            'Appels d\'offres' => 'Appels d\'offres',
            'Evènement' => 'Evènement',
            'Échéance' => 'Échéance',
            'Concurrence' => 'Concurrence',
            'Règlementation' => 'Règlementation',
            'Collectivités' => 'Collectivités',
            'Prospective' => 'Prospective',
            'Rapports' => 'Rapports',
            'Techno' => 'Techno',
            'Livres' => 'Livres',
            'Musique' => 'Musique',
            'Personnalité' => 'Personnalité',
            'Paroles' => 'Paroles',
            'Données' => 'Données',
            'A Nantes' => 'A Nantes',
            'A Nancy' => 'A Nancy',
            'Divers' => 'Divers',
        ];
    }

    /**
     * @return array
     */
    public static function getFiliereList()
    {
        return [
            'Eolienne' => 'Eolienne', 
            'PV' => 'PV',
            'Enr' => 'Enr',
            'Divers' => 'Divers'
        ];
    }

    /**
     * @return string
     */
    public function getFiliere()
    {
        return $this->filiere;
    }

    /**
     *
     * @param string $filiere
     * @return \AppBundle\Entity\News
     */
    public function setFiliere($filiere)
    {
        $this->filiere = $filiere;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitre()
    {
        return $this->titre;
    }

    /**
     *
     * @param string $titre
     * @return \AppBundle\Entity\News
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
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
     * @return \AppBundle\Entity\News
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     *
     * @param string $url
     * @return \AppBundle\Entity\News
     */
    public function setUrl($url)
    {
        $this->url = $url;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateSaisie()
    {
        return $this->dateSaisie;
    }
    
    /**
     * @param DateTime|null $dateSaisie
     * @return $this
     */
    public function setDateSaisie(DateTime $dateSaisie = null)
    {
        $this->dateSaisie = $dateSaisie;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateParution()
    {
        return $this->dateParution;
    }
    
    /**
     * @param DateTime|null $dateParution
     * @return $this
     */
    public function setDateParution(DateTime $dateParution = null)
    {
        $this->dateParution = $dateParution;
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'News';
    }
}

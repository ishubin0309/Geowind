<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity
 */
class DateCle
{
    const CODE_T0 = 'T0';
    const CODE_T1 = 'T1';
    const CODE_T2 = 'T2';
    const CODE_T3 = 'T3';
    const CODE_TX = 'TX'; // Custom
    
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
     * @var DateTime
     *
     * @ORM\Column(type="date")
     * @Assert\Date()
     * @Assert\NotBlank()
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string")
     */
    private $code;
    
    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="dateCles")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $projet;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    
    /**
     * @return DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * @param DateTime $date
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription($description)
    {
        $this->description = $description;
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
     * @return $this
     */
    public function setCode($code)
    {
        $this->code = $code;
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
     * @param \AppBundle\Entity\Projet $projet
     * @return $this
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
        return $this->parcelles;
    }
    
    /**
     * @return string
     */
    public function getLabel()
    {
        $labels = self::getCodeList();
        
        switch ($this->code) {
            case self::CODE_T0:
                return $labels[self::CODE_T0];
            case self::CODE_T1:
                return $labels[self::CODE_T1];
            case self::CODE_T2:
                return $labels[self::CODE_T2];
            case self::CODE_T3:
                return $labels[self::CODE_T3];
            default:
                return $this->description;
        }
    }
    
    /**
     * @return array
     */
    public static function getCodeList()
    {
        return [
          self::CODE_T0 => 'T0 : Engagement',  
          self::CODE_T1 => 'T1 : Remise études',  
          self::CODE_T2 => 'T2 : Dépôt dossier',  
          self::CODE_T3 => 'T3 : Décision admin',  
          self::CODE_TX => 'Autres dates',
        ];
    }
}

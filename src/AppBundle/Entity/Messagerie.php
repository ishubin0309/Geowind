<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entité Messagerie
 *
 * @author Haffoudhi
 *
 * @ORM\Entity()
 */
class Messagerie
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
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    private $body;
    
    /**
     * @var ArrayCollection|User[]
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="messageries", cascade={"persist"})
     */
    private $viewers;

    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="messages")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $projet;

    public function __construct()
    {
        $this->viewers = new ArrayCollection();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->body;
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

    /**
     * @return User
     */
    public function getFrom()
    {
        return $this->from;
    }

    /**
     * @param User $from
     * @return \AppBundle\Entity\Messagerie
     */
    public function setFrom(User $from)
    {
        $this->from = $from;
        return $this;
    }

    public function getBody()
    {
        return $this->body;
    }

    public function setBody($body)
    {
        $this->body = $body;
        return $this;
    }

    /**
     * @return ArrayCollection|User[]
     */
    public function getViewers()
    {
        return $this->viewers;
    }

    /**
     * @param \AppBundle\Entity\User $viewer
     */
    public function addViewer(User $viewer)
    {
        if (!$this->viewers->contains($viewer)) {
            $viewer->addMessagerie($this);
            $this->viewers[] = $viewer;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $viewers
     * @return \AppBundle\Entity\Messagerie
     */
    public function setViewers(ArrayCollection $viewers)
    {
        $this->viewers = $viewers;
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
     * @return \AppBundle\Entity\Terrain
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }
}

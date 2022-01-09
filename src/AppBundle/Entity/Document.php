<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Document entity
 *
 * @author Haffoudhi
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\DocumentRepository")
 * @Vich\Uploadable
 */
class Document
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
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $titre;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $etat;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $dynamique;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $description;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $documentOriginalName = 'document';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff", fileNameProperty="document")
     */
    private $documentFile;

    /**
     * @var Projet
     *
     * @ORM\ManyToOne(targetEntity="Projet", inversedBy="documents")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     * @Assert\NotBlank()
     */
    private $projet;

    /**
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $plan = false;

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
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return \AppBundle\Entity\Document
     */
    public function setType($type)
    {
        $this->type = $type;
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
     * @param string $titre
     * @return \AppBundle\Entity\Document
     */
    public function setTitre($titre)
    {
        $this->titre = $titre;
        return $this;
    }

    /**
     * @return string
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     *
     * @param string $document
     * @return \AppBundle\Entity\Document
     */
    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getDocumentFile()
    {
        return $this->documentFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $document
     *
     * @return $this
     */
    public function setDocumentFile(File $document = null)
    {
        $this->documentFile = $document;
        if ($document) {
            if ($document instanceof UploadedFile) {
                $this->documentOriginalName = $document->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getDocumentOriginalName()
    {
        return $this->documentOriginalName;
    }

    /**
     * @param string $documentOriginalName
     * @return \AppBundle\Entity\Document
     */
    public function setDocumentOriginalName($documentOriginalName)
    {
        $this->documentOriginalName = $documentOriginalName;
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
     *
     * @param string $description
     * @return \AppBundle\Entity\Document
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return bool
     */
    public function isPlan()
    {
        return $this->plan;
    }

    /**
     * @return Projet
     */
    public function getProjet()
    {
        return $this->projet;
    }

    /**
     * @return DateTime|null
     */
    public function getDate()
    {
        return $this->date;
    }
    
    /**
     * @param DateTime|null $date
     * @return $this
     */
    public function setDate(DateTime $date = null)
    {
        $this->date = $date;
        return $this;
    }

    /**
     * @param bool $plan
     * @return \AppBundle\Entity\Document
     */
    public function setPlan($plan)
    {
        $this->plan = $plan;
        return $this;
    }

    /**
     * @param Projet $projet
     * @return \AppBundle\Entity\Document
     */
    public function setProjet(Projet $projet)
    {
        $this->projet = $projet;
        return $this;
    }

    /**
     * @return array
     */
    public static function getTypeList()
    {
        return [
            'plan_contexte' => 'Plan de contexte',
            'plan_zonage' => 'Plan de zonage',
            'plan_implantation' => 'Plan d\'implantation',
            'maitrise_fonciere' => 'Maîtrise foncière',
            'delibération' => 'Délibération',
            'pre_faisabilite' => 'Pré-faisabilité',
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return 'Document';
    }
}

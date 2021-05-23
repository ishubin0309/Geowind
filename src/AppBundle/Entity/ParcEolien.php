<?php

namespace AppBundle\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Parc Eolien
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ParcEolienRepository")
 * @Vich\Uploadable
 */
class ParcEolien
{
    use BlameableTrait;
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     * @ORM\Id
     */
    private $id;
    
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
    private $insee;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $region;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $departement;
    
    /**
     * @var string
     *
     * @ORM\Column(type="float")
     */
    private $latitude = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="float")
     */
    private $longitude = 0;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $denomination;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $miseEnService;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $typeMachine;
    
    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=18, scale=6)
     */
    private $puissanceNominaleUnitaire = 0;
    
    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=18, scale=6)
     */
    private $puissanceNominaleTotale = 0;
    
    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=18, scale=6)
     */
    private $productibleEstime = 0;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $developpeur;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $operateur;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $nomContact;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $telephoneContact;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="string", nullable=true)
     */
    private $emailContact;
    
    /**
     * @var string
     * 
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

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
    private $documentOriginalName;

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="document", fileNameProperty="document")
     */
    private $documentFile;
    
    public function getId()
    {
        return $this->id;
    }

    public function getCommune()
    {
        return $this->commune;
    }

    public function getInsee()
    {
        return $this->insee;
    }

    public function getRegion()
    {
        return $this->region;
    }

    public function getDepartement()
    {
        return $this->departement;
    }

    public function getLatitude()
    {
        return $this->latitude;
    }

    public function getLongitude()
    {
        return $this->longitude;
    }

    public function getDenomination()
    {
        return $this->denomination;
    }

    public function getMiseEnService()
    {
        return $this->miseEnService;
    }

    public function getTypeMachine()
    {
        return $this->typeMachine;
    }

    public function getPuissanceNominaleUnitaire()
    {
        return (float) $this->puissanceNominaleUnitaire;
    }

    public function getPuissanceNominaleTotale()
    {
        return (float) $this->puissanceNominaleTotale;
    }

    public function getProductibleEstime()
    {
        return (float) $this->productibleEstime;
    }

    public function getDeveloppeur()
    {
        return $this->developpeur;
    }

    public function getOperateur()
    {
        return $this->operateur;
    }

    public function getNomContact()
    {
        return $this->nomContact;
    }

    public function getTelephoneContact()
    {
        return $this->telephoneContact;
    }

    public function getEmailContact()
    {
        return $this->emailContact;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getDocument()
    {
        return $this->document;
    }

    public function getDocumentOriginalName()
    {
        return $this->documentOriginalName;
    }

    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    public function setCommune($commune)
    {
        $this->commune = $commune;
        return $this;
    }

    public function setInsee($insee)
    {
        $this->insee = $insee;
        return $this;
    }

    public function setRegion($region)
    {
        $this->region = $region;
        return $this;
    }

    public function setDepartement($departement)
    {
        $this->departement = $departement;
        return $this;
    }

    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;
        return $this;
    }

    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;
        return $this;
    }

    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;
        return $this;
    }

    public function setMiseEnService($miseEnService)
    {
        $this->miseEnService = $miseEnService;
        return $this;
    }

    public function setTypeMachine($typeMachine)
    {
        $this->typeMachine = $typeMachine;
        return $this;
    }

    public function setPuissanceNominaleUnitaire($puissanceNominaleUnitaire)
    {
        $this->puissanceNominaleUnitaire = $puissanceNominaleUnitaire;
        return $this;
    }

    public function setPuissanceNominaleTotale($puissanceNominaleTotale)
    {
        $this->puissanceNominaleTotale = $puissanceNominaleTotale;
        return $this;
    }

    public function setProductibleEstime($productibleEstime)
    {
        $this->productibleEstime = $productibleEstime;
        return $this;
    }

    public function setDeveloppeur($developpeur)
    {
        $this->developpeur = $developpeur;
        return $this;
    }

    public function setOperateur($operateur)
    {
        $this->operateur = $operateur;
        return $this;
    }

    public function setNomContact($nomContact)
    {
        $this->nomContact = $nomContact;
        return $this;
    }

    public function setTelephoneContact($telephoneContact)
    {
        $this->telephoneContact = $telephoneContact;
        return $this;
    }

    public function setEmailContact($emailContact)
    {
        $this->emailContact = $emailContact;
        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public function setDocument($document)
    {
        $this->document = $document;
        return $this;
    }

    public function setDocumentOriginalName($documentOriginalName)
    {
        $this->documentOriginalName = $documentOriginalName;
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
            $this->updatedAt = new DateTime();
        }

        return $this;
    }
    
    public function getRowForExport()
    {
        return [
            $this->id, 
            $this->denomination, 
            $this->region, 
            $this->departement, 
            $this->commune, 
            $this->insee, 
            $this->longitude, 
            $this->latitude, 
            $this->miseEnService, 
            $this->typeMachine, 
            $this->puissanceNominaleUnitaire, 
            $this->puissanceNominaleTotale, 
            $this->productibleEstime, 
            $this->developpeur, 
            $this->operateur, 
            $this->nomContact, 
            $this->telephoneContact, 
            $this->emailContact, 
            $this->description
        ];
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->denomination)) {
            return (string) $this->id;
        }
        return (string) $this->denomination;
    }
}

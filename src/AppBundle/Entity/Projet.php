<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use AppBundle\Entity\Traits\BlameableTrait;
use AppBundle\Entity\Traits\TimestampableTrait;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\File;
use AppBundle\Entity\User;

/**
 * Projet entity
 *
 * @author Stéphane Ear <stephaneear@gmail.com>
 *
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ProjetRepository")
 * @ORM\HasLifecycleCallbacks()
 * @Vich\Uploadable
 */
class Projet
{
    use BlameableTrait;
    use TimestampableTrait;

    const TYPE_PROJET_UN = 'parc__eolien';
    const TYPE_PROJET_DEUX = 'ferme_solaire';
    const TYPE_PROJET_TROIS = 'ombriere_solaire';
    const TYPE_PROJET_QUATRE = 'tracker_solaire';
    const TYPE_PROJET_CINQ = 'eolienne_isolee';
    const TYPE_PROJET_SIX = 'toiture_solaire';
    const TYPE_PROJET_SEPT = 'mesure_enviro';

    const TYPE_SITE_UN = 'terrain';
    const TYPE_SITE_DEUX = 'batiment_existant';
    const TYPE_SITE_TROIS = 'nouveau_batiment';
    const TYPE_SITE_QUATRE = 'parking';
    const TYPE_SITE_CINQ = 'plan_deau';

    const BATIMENT_UN = 'type1';

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
     */
    private $dateCreation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="type_projet")
     * @Assert\NotBlank()
     */
    private $typeProjet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="type_site")
     * @Assert\NotBlank()
     */
    private $typeSite;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $adresse;

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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $origine;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="origine_telephone", nullable=true)
     */
    private $origineTelephone;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $chargeFoncier;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="charge_foncier_telephone", nullable=true)
     */
    private $chargeFoncierTelephone;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $chefProjet;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="chef_projet_telephone", nullable=true)
     */
    private $chefProjetTelephone;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumn(nullable=true, onDelete="SET NULL")
     */
    private $partenaire;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="partenaire_telephone", nullable=true)
     */
    private $partenaireTelephone;

    /**
     * @var Departement
     *
     * @ORM\ManyToOne(targetEntity="Departement")
     */
    private $departement;

    /**
     * @var Mairie
     *
     * @ORM\ManyToOne(targetEntity="Mairie", inversedBy="projets")
     */
    private $mairie;

    /**
     * @var string
     *
     * @ORM\Column(type="string", name="mairie_telephone", nullable=true)
     */
    private $mairieTelephone;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photoImplantation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $photoImplantationOriginalName = 'photoImplantation';

    /**
     * @var UploadedFile
     *
     * @Vich\UploadableField(mapping="geotiff", fileNameProperty="photoImplantation")
     */
    private $photoImplantationFile;

    /**
     * @var ArrayCollection|Commune[]
     *
     * @ORM\ManyToMany(targetEntity="Commune", inversedBy="projets", cascade={"persist"})
     */
    private $communes;

    /**
     * @var Terrain
     *
     * @ORM\OneToOne(targetEntity="Terrain", inversedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $terrain;

    /**
     * @var ArrayCollection|Enjeux[]
     *
     * @ORM\OneToMany(targetEntity="Enjeux", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $enjeuxs;

    /**
     * @var ArrayCollection|Etat[]
     *
     * @ORM\OneToMany(targetEntity="Etat", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $etats;

    /**
     * @var ArrayCollection|Tache[]
     *
     * @ORM\OneToMany(targetEntity="Tache", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $taches;

    /**
     * @var ArrayCollection|Concertation[]
     *
     * @ORM\OneToMany(targetEntity="Concertation", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $concertations;

    /**
     * @var ArrayCollection|Document[]
     *
     * @ORM\OneToMany(targetEntity="Document", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"plan" = "DESC"})
     */
    private $documents;

    /**
     * @var ArrayCollection|Parcelle[]
     *
     * @ORM\OneToMany(targetEntity="Parcelle", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $parcelles;

    /**
     * @var ArrayCollection|Note[]
     *
     * @ORM\OneToMany(targetEntity="Note", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $notes;

    /**
     * @var Batiment
     *
     * @ORM\OneToOne(targetEntity="Batiment", inversedBy="projet", cascade={"all"}, orphanRemoval=true)
     */
    private $batimentExistant;

    /**
     * @var Batiment
     *
     * @ORM\ManyToOne(targetEntity="BatimentNouveau", inversedBy="projets")
     */
    private $batimentNouveau;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $denomination;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $environnement;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=6)
     */
    private $potentiel = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $progression;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $phase;

    /**
     * @var ArrayCollection|Finance[]
     *
     * @ORM\OneToMany(targetEntity="Finance", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC" })
     */
    private $finances;
    
    /**
     * @var ArrayCollection|Proprietaire[]
     *
     * @ORM\OneToMany(targetEntity="Proprietaire", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC" })
     */
    private $proprietaires;
    
    /**
     * @var ArrayCollection|Messagerie[]
     *
     * @ORM\OneToMany(targetEntity="Messagerie", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"id" = "ASC" })
     */
    private $messages;
    
    /**
     * @var ArrayCollection|DateCle[]
     *
     * @ORM\OneToMany(targetEntity="DateCle", mappedBy="projet", cascade={"all"}, orphanRemoval=true)
     * @ORM\OrderBy({"date" = "ASC" })
     */
    private $dateCles;
    
    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $commentaires;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateT0;
    
    /**
     * @var DateTime
     * 
     * @ORM\Column(type="date", nullable=true)
     */
    private $dateT1;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $typeImplantation;

    /**
     * @var string
     *
     * @ORM\Column(type="string", nullable=true)
     */
    private $titreImplantation;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $contrat;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $debouche;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $tarif;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $technologie;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    private $equipement;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    private $surfaceUtile = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $voiries = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $lineaire = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $interdistance = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 0})
     */
    private $unite = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=6, name="puissance_unitaire")
     */
    private $puissanceUnitaire = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=6, name="puissance_totale")
     */
    private $puissanceTotale = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=6)
     */
    private $production = 0;

    /**
     * @var string
     *
     * @ORM\Column(type="decimal", precision=12, scale=6)
     */
    private $emprise = 0;

    /**
     * @var int
     *
     * @ORM\Column(type="integer", options={"default" : 15})
     */
    private $completude = 0;

    /**
     * @var Liste
     *
     * @ORM\ManyToOne(targetEntity="Liste", inversedBy="projets")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $liste;
    
    /**
     * @var bool
     * 
     * @ORM\Column(type="boolean")
     */
    private $archived = false;

    public function __construct()
    {
        $this->dateCreation = new DateTime('today');
        $this->finances = new ArrayCollection();
        $this->communes = new ArrayCollection();
        $this->enjeuxs = new ArrayCollection();
        $this->etats = new ArrayCollection();
        $this->taches = new ArrayCollection();
        $this->concertations = new ArrayCollection();
        $this->documents = new ArrayCollection();
        $this->parcelles = new ArrayCollection();
        $this->notes = new ArrayCollection();
        $this->proprietaires = new ArrayCollection();
    }

    /**
     * @return array
     */
    public static function getTypeProjetList()
    {
        return [
            self::TYPE_PROJET_UN => 'Parc éolien',
            self::TYPE_PROJET_DEUX => 'Ferme solaire',
            self::TYPE_PROJET_TROIS => 'Ombrière solaire',
            self::TYPE_PROJET_QUATRE => 'Tracker solaire',
            self::TYPE_PROJET_CINQ => 'Eolienne isolée',
            self::TYPE_PROJET_SIX => 'Toiture solaire',
            self::TYPE_PROJET_SEPT => 'Mesure enviro'
        ];
    }

    /**
     * @return array
     */
    public static function getTypeSiteList()
    {
        return [
            self::TYPE_SITE_UN => 'Terrain',
            self::TYPE_SITE_DEUX => 'Bâtiment existant',
            self::TYPE_SITE_TROIS => 'Nouveau bâtiment',
            self::TYPE_SITE_QUATRE => 'Parking',
            self::TYPE_SITE_CINQ => 'Plan d’eau'
        ];
    }

    /**
     * @return array
     */
    public static function getBatimentList()
    {
        return [
            self::BATIMENT_UN => 'Type1'
        ];
    }
    
    /**
     * @return array
     */
    public static function getContratList()
    {
        return [
            'location' => 'Location',
            'investissement' => 'Investissement',
            'vente' => 'Vente',
            'non_defini' => 'Non-défini',
        ];
    }
    
    /**
     * @return array
     */
    public static function getValorisationList()
    {
        return [
            'injection' => 'Injection',
            'autoconso_i' => 'Autoconso-i',
            'autoconso_c' => 'Autoconso-c',
            'mixte' => 'Mixte',
            'ct_remuneration'=> 'Ct de rémunération',
            'non_defini' => 'Non-défini',
            'biodiversite' => 'Biodiversité',
            'cession' => 'Cession'
        ];
    }
    
    /**
     * @return array
     */
    public static function getTarifList()
    {
        return [
            'Appel d\'offre'=> 'Appel d\'offre',
            'PPA' => 'PPA'
        ];
    }
    
    /**
     * @return array
     */
    public static function getTypeImplantationList()
    {
        return [
            'plan_ign' => 'Plan IGN',
            'plan_cadastre' => 'Plan cadastre',
            'photo_aerienne' => 'Photo aerienne'
        ];
    }
    
    /**
     * @return array
     */
    public static function getTitreImplantationList()
    {
        return [
            'zonage' => 'Zonage',
            'esquisse' => 'Esquisse',
            'avant_projet' => 'Avant projet',
            'projet_definitif' => 'Projet définitif'
        ];
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getTypeProjet()
    {
        return $this->typeProjet;
    }

    /**
     * @param int $typeProjet
     * @return \AppBundle\Entity\Projet
     */
    public function setTypeProjet($typeProjet)
    {
        $this->typeProjet = $typeProjet;
        return $this;
    }

    /**
     * @return int
     */
    public function getTypeSite()
    {
        return $this->typeSite;
    }

    /**
     * @param int $typeSite
     * @return \AppBundle\Entity\Projet
     */
    public function setTypeSite($typeSite)
    {
        $this->typeSite = $typeSite;
        return $this;
    }

    /**
     * @return int
     */
    public function getAdresse()
    {
        return $this->adresse;
    }

    /**
     * @param int $adresse
     * @return \AppBundle\Entity\Projet
     */
    public function setAdresse($adresse)
    {
        $this->adresse = $adresse;
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
     * @return User
     */
    public function getOrigine()
    {
        return $this->origine;
    }

    /**
     * @param User $origine
     * @return \AppBundle\Entity\Projet
     */
    public function setOrigine(User $origine)
    {
        $this->origine = $origine;
        return $this;
    }

    /**
     * @return User
     */
    public function getChargeFoncier()
    {
        return $this->chargeFoncier;
    }

    /**
     * @param User $chargeFoncier
     * @return \AppBundle\Entity\Projet
     */
    public function setChargeFoncier($chargeFoncier)
    {
        $this->chargeFoncier = $chargeFoncier;
        return $this;
    }

    /**
     * @return User
     */
    public function getChefProjet()
    {
        return $this->chefProjet;
    }

    /**
     * @param User $chefProjet
     * @return \AppBundle\Entity\Projet
     */
    public function setChefProjet($chefProjet)
    {
        $this->chefProjet = $chefProjet;
        return $this;
    }

    /**
     * @return User
     */
    public function getPartenaire()
    {
        return $this->partenaire;
    }

    /**
     * @param User $partenaire
     * @return \AppBundle\Entity\Projet
     */
    public function setPartenaire($partenaire)
    {
        $this->partenaire = $partenaire;
        return $this;
    }

    public function getOrigineTelephone()
    {
        return $this->origineTelephone;
    }

    public function setOrigineTelephone($origineTelephone)
    {
        $this->origineTelephone = $origineTelephone;
        return $this;
    }

    public function getChargeFoncierTelephone()
    {
        return $this->chargeFoncierTelephone;
    }

    public function setChargeFoncierTelephone($chargeFoncierTelephone)
    {
        $this->chargeFoncierTelephone = $chargeFoncierTelephone;
        return $this;
    }

    public function getChefProjetTelephone()
    {
        return $this->chefProjetTelephone;
    }

    public function setChefProjetTelephone($chefProjetTelephone)
    {
        $this->chefProjetTelephone = $chefProjetTelephone;
        return $this;
    }

    public function getPartenaireTelephone()
    {
        return $this->partenaireTelephone;
    }

    public function setPartenaireTelephone($partenaireTelephone)
    {
        $this->partenaireTelephone = $partenaireTelephone;
        return $this;
    }

    /**
     * @return Departement
     */
    public function getDepartement()
    {
        return $this->departement;
    }

    /**
     * @param \AppBundle\Entity\Departement $departement
     * @return \AppBundle\Entity\Projet
     */
    public function setDepartement(Departement $departement)
    {
        $this->departement = $departement;
        return $this;
    }

    /**
     * @return Mairie
     */
    public function getMairie()
    {
        return $this->mairie;
    }

    /**
     * @param \AppBundle\Entity\Mairie $mairie
     * @return \AppBundle\Entity\Projet
     */
    public function setMairie(Mairie $mairie)
    {
        $this->mairie = $mairie;
        return $this;
    }

    public function getMairieTelephone()
    {
        return $this->mairieTelephone;
    }

    public function setMairieTelephone($mairieTelephone)
    {
        $this->mairieTelephone = $mairieTelephone;
        return $this;
    }

    /**
     * @return ArrayCollection|Commune[]
     */
    public function getCommunes()
    {
        return $this->communes;
    }

    /**
     * @param \AppBundle\Entity\Commune $commune
     */
    public function addCommune(Commune $commune)
    {
        if (!$this->communes->contains($commune)) {
            $this->communes[] = $commune;
        }
        return $this;
    }

    /**
     * @param ArrayCollection $communes
     * @return \AppBundle\Entity\Projet
     */
    public function setCommunes(ArrayCollection $communes)
    {
        $this->communes = $communes;
        return $this;
    }

    /**
     * @return Terrain $terrain
     */
    public function getTerrain()
    {
        return $this->terrain;
    }

    /**
     * @param Terrain $terrain
     * @return \AppBundle\Entity\Projet
     */
    public function setTerrain(Terrain $terrain)
    {
        $this->terrain = $terrain;
        return $this;
    }

    /**
     * @return ArrayCollection|Enjeux[]
     */
    public function getEnjeuxs()
    {
        return $this->enjeuxs;
    }

    /**
     * @param ArrayCollection $enjeuxs
     * @return \AppBundle\Entity\Projet
     */
    public function setEnjeuxs(ArrayCollection $enjeuxs)
    {
        $this->enjeuxs = $enjeuxs;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Enjeux $enjeux
     */
    public function addEnjeux(Enjeux $enjeux)
    {
        if (!$this->enjeuxs->contains($enjeux)) {
            $enjeux->setProjet($this);
            $this->enjeuxs->add($enjeux);
        }
    }

    /**
     * @param \AppBundle\Entity\Enjeux $enjeux
     */
    public function removeEnjeux(Enjeux $enjeux)
    {
        $this->enjeuxs->removeElement($enjeux);
    }

    /**
     * @return ArrayCollection|Etat[]
     */
    public function getEtats()
    {
        return $this->etats;
    }

    /**
     * @param ArrayCollection $etats
     * @return \AppBundle\Entity\Projet
     */
    public function setEtats(ArrayCollection $etats)
    {
        $this->etats = $etats;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Etat $etat
     */
    public function addEtat(Etat $etat)
    {
        if (!$this->etats->contains($etat)) {
            $etat->setProjet($this);
            $this->etats->add($etat);
            $this->progression = $etat->getEtat();
            $this->phase = $etat->getPhase();
        }
    }

    /**
     * @param \AppBundle\Entity\Etat $etat
     */
    public function removeEtat(Etat $etat)
    {
        $this->etats->removeElement($etat);
    }

    /**
     * @return ArrayCollection|Tache[]
     */
    public function getTaches()
    {
        return $this->taches;
    }

    /**
     * @param ArrayCollection $taches
     * @return \AppBundle\Entity\Projet
     */
    public function setTaches(ArrayCollection $taches)
    {
        $this->taches = $taches;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Tache $tache
     */
    public function addTache(Tache $tache)
    {
        if (!$this->taches->contains($tache)) {
            $tache->setProjet($this);
            $this->taches->add($tache);
        }
    }

    /**
     * @param \AppBundle\Entity\Tache $tache
     */
    public function removeTache(Tache $tache)
    {
        $this->taches->removeElement($tache);
    }

    /**
     * @return ArrayCollection|Concertation[]
     */
    public function getConcertations()
    {
        return $this->concertations;
    }

    /**
     * @param ArrayCollection $concertations
     * @return \AppBundle\Entity\Projet
     */
    public function setConcertations(ArrayCollection $concertations)
    {
        $this->concertations = $concertations;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Concertation $concertation
     */
    public function addConcertation(Concertation $concertation)
    {
        if (!$this->concertations->contains($concertation)) {
            $concertation->setProjet($this);
            $this->concertations->add($concertation);
        }
    }

    /**
     * @param \AppBundle\Entity\Concertation $concertation
     */
    public function removeConcertation(Concertation $concertation)
    {
        $this->concertations->removeElement($concertation);
    }

    /**
     * @return ArrayCollection|Document[]
     */
    public function getDocuments()
    {
        return $this->documents;
    }

    /**
     * @param ArrayCollection $documents
     * @return \AppBundle\Entity\Projet
     */
    public function setDocuments(ArrayCollection $documents)
    {
        $this->documents = $documents;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Document $document
     */
    public function addDocument(Document $document)
    {
        if (!$this->documents->contains($document)) {
            if(/*!$this->documents->count() && */!$document->getDocument() && $document->isPlan() && $this->photoImplantationFile) {
                $target_file = uniqid() . '_' . $this->photoImplantationOriginalName;
                copy($this->photoImplantationFile, 'upload/'.$target_file);
                $document->setDocument($target_file);
                $document->setDocumentOriginalName($this->photoImplantationOriginalName);
            }
            $document->setProjet($this);
            $this->documents->add($document);
        }
    }

    /**
     * @param \AppBundle\Entity\Document $document
     */
    public function removeDocument(Document $document)
    {
        $this->documents->removeElement($document);
    }

    /**
     * @return ArrayCollection|Parcelle[]
     */
    public function getParcelles()
    {
        return $this->parcelles;
    }

    /**
     * @param ArrayCollection $parcelles
     * @return \AppBundle\Entity\Projet
     */
    public function setParcelles(ArrayCollection $parcelles)
    {
        $this->parcelles = $parcelles;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Parcelle $parcelle
     */
    public function addParcelle(Parcelle $parcelle)
    {
        if (!$this->parcelles->contains($parcelle)) {
            $parcelle->setProjet($this);
            $this->parcelles->add($parcelle);
        }
    }

    /**
     * @param \AppBundle\Entity\Parcelle $parcelle
     */
    public function removeParcelle(Parcelle $parcelle)
    {
        $this->parcelles->removeElement($parcelle);
    }

    /**
     * @return ArrayCollection|Note[]
     */
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param ArrayCollection $notes
     * @return \AppBundle\Entity\Projet
     */
    public function setNotes(ArrayCollection $notes)
    {
        $this->notes = $notes;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Note $note
     */
    public function addNote(Note $note)
    {
        if (!$this->notes->contains($note)) {
            $note->setProjet($this);
            $this->notes->add($note);
        }
    }

    /**
     * @param \AppBundle\Entity\Note $note
     */
    public function removeNote(Note $note)
    {
        $this->notes->removeElement($note);
    }

    /**
     * @return Batiment $batimentExistant
     */
    public function getBatimentExistant()
    {
        return $this->batimentExistant;
    }

    /**
     * @param Batiment $batimentExistant
     * @return \AppBundle\Entity\Projet
     */
    public function setBatimentExistant(Batiment $batimentExistant)
    {
        $this->batimentExistant = $batimentExistant;
        return $this;
    }
    
    public function getBatimentNouveau()
    {
        return $this->batimentNouveau;
    }
    
    /**
     * @param BatimentNouveau $batimentNouveau
     * @return \AppBundle\Entity\Projet
     */
    public function setBatimentNouveau(BatimentNouveau $batimentNouveau)
    {
        $this->batimentNouveau = $batimentNouveau;
        return $this;
    }

    public function getDenomination()
    {
        return $this->id ? str_replace('_id', '_'.$this->id, $this->denomination) : $this->denomination;
    }

    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;
        return $this;
    }

    /**
     * @return string
     */
    public function getEnvironnement()
    {
        return $this->environnement;
    }

    /**
     * @param string $environnement
     * @return \AppBundle\Entity\Projet
     */
    public function setEnvironnement($environnement)
    {
        $this->environnement = $environnement;
        return $this;
    }

    /**
     * @return float
     */
    public function getPotentiel()
    {
        return floatval($this->potentiel);
    }

    /**
     * @param string $potentiel
     * @return \AppBundle\Entity\Projet
     */
    public function setPotentiel($potentiel)
    {
        $this->potentiel = $potentiel;
        return $this;
    }

    /**
     * @return string
     */
    public function getProgression()
    {
        return $this->progression;
    }

    /**
     * @param string $progression
     * @return \AppBundle\Entity\Projet
     */
    public function setProgression($progression)
    {
        $this->progression = $progression;
        return $this;
    }

    /**
     * @return string
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * @param string $phase
     * @return \AppBundle\Entity\Projet
     */
    public function setPhase($phase)
    {
        $this->phase = $phase;
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
     * @return \AppBundle\Entity\Projet
     */
    public function setFinances(ArrayCollection $finances)
    {
        $this->finances = $finances;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Finance $finance
     */
    public function addFinance(Finance $finance)
    {
        if (!$this->finances->contains($finance)) {
            $finance->setProjet($this);
            $this->finances->add($finance);
        }
    }

    /**
     * @param \AppBundle\Entity\Finance $finance
     */
    public function removeFinance(Finance $finance)
    {
        $this->finances->removeElement($finance);
    }
    
    /**
     * @return ArrayCollection|Proprietaire[]
     */
    public function getProprietaires()
    {
        return $this->proprietaires;
    }

    /**
     * @param ArrayCollection $proprietaires
     * @return \AppBundle\Entity\Projet
     */
    public function setProprietaires(ArrayCollection $proprietaires)
    {
        $this->proprietaires = $proprietaires;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Proprietaire $proprietaire
     */
    public function addProprietaire(Proprietaire $proprietaire)
    {
        if (!$this->proprietaires->contains($proprietaire)) {
            $proprietaire->setProjet($this);
            $this->proprietaires->add($proprietaire);
        }
    }

    /**
     * @param \AppBundle\Entity\Proprietaire $proprietaire
     */
    public function removeProprietaire(Proprietaire $proprietaire)
    {
        $this->proprietaires->removeElement($proprietaire);
    }
    
    /**
     * @return ArrayCollection|Messagerie[]
     */
    public function getMessages()
    {
        return $this->messages;
    }

    /**
     * @param ArrayCollection $messages
     * @return \AppBundle\Entity\Projet
     */
    public function setMessages(ArrayCollection $messages)
    {
        $this->messages = $messages;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\Messagerie $message
     */
    public function addMessage(Messagerie $message)
    {
        if (!$this->messages->contains($message)) {
            $message->setProjet($this);
            $this->messages->add($message);
        }
    }

    /**
     * @param \AppBundle\Entity\Messagerie $message
     */
    public function removeMessage(Messagerie $message)
    {
        $this->messages->removeElement($message);
    }
    
    /**
     * @return ArrayCollection|DateCle[]
     */
    public function getDateCles()
    {
        return $this->dateCles;
    }
    
    /**
     * @return array
     */
    public function getDateClesInversed()
    {
        return array_reverse($this->dateCles->toArray());
    }

    /**
     * @param ArrayCollection $dateCles
     * @return \AppBundle\Entity\Projet
     */
    public function setDateCles(ArrayCollection $dateCles)
    {
        $this->dateCles = $dateCles;
        return $this;
    }
    
    /**
     * @param \AppBundle\Entity\DateCle $dateCle
     */
    public function addDateCle(DateCle $dateCle)
    {
        if (!$this->dateCles->contains($dateCle)) {
            $dateCle->setProjet($this);
            $this->dateCles->add($dateCle);
        }
    }

    /**
     * @param \AppBundle\Entity\DateCle $dateCle
     */
    public function removeDateCle(DateCle $dateCle)
    {
        $this->dateCles->removeElement($dateCle);
    }
    
    /**
     * @return string
     */
    public function getCommentaires()
    {
        return $this->commentaires;
    }

    /**
     * @param string $commentaires
     * @return \AppBundle\Entity\Projet
     */
    public function setCommentaires($commentaires)
    {
        $this->commentaires = $commentaires;
        return $this;
    }

    /**
     * @return DateTime
     */
    public function getDateCreation()
    {
        return $this->dateCreation;
    }

    /**
     * @param DateTime $dateCreation
     * @return \AppBundle\Entity\Projet
     */
    public function setDateCreation(DateTime $dateCreation = null)
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    /**
     * @return float
     */
    public function getMontantEngage()
    {
        $somme = 0;
        foreach ($this->finances as $finance) {
            $somme += $finance->getMontantEngage();
        }
        return $somme;
    }

    /**
     * @return float
     */
    public function getMontantPaye()
    {
        $somme = 0;
        foreach ($this->finances as $finance) {
            $somme += $finance->getMontantPaye();
        }
        return $somme;
    }

    /**
     * @return string
     */
    public function getCommunesInline()
    {
        $communes = '';
        foreach ($this->communes as $commune) {
            if (!empty($communes)) {
                $communes .= ', ';
            }
            $communes .= $commune->getNom();
        }
        return $communes;
    }

    /**
     * Alias pour getUpdatedAt()
     *
     * @return DateTime
     */
    public function getDateMaj()
    {
        return $this->getUpdatedAt();
    }
    
    /**
     * @return DateTime|null
     */
    public function getDateT0()
    {
        return $this->dateT0;
    }
    
    /**
     * @param DateTime|null $dateT0
     * @return $this
     */
    public function setDateT0(DateTime $dateT0 = null)
    {
        $this->dateT0 = $dateT0;
        return $this;
    }

    /**
     * @return DateTime|null
     */
    public function getDateT1()
    {
        return $this->dateT1;
    }
    
    /**
     * @param DateTime|null $dateT1
     * @return $this
     */
    public function setDateT1(DateTime $dateT1 = null)
    {
        $this->dateT1 = $dateT1;
        return $this;
    }
    
    public function getDateT1Progression()
    {
        
        if ($this->dateT0 != null && $this->dateT1 != null) {
            
            $t0 = clone $this->dateT0;
            $t1 = clone $this->dateT1;
            
            $t0->setTime(0, 0, 0);
            $t1->setTime(0, 0, 0);
            
            $today = new DateTime('today 00:00');
            
            if ($today <= $this->dateT0) {
                return 0;
            }
            
            if ($this->dateT1 <= $this->dateT0) {
                return 100;
            }
            
            $interval = $today->diff($this->dateT0);
            $sinceT0 = intval($interval->format('%a'));

            $intervalT0T1 = $this->dateT1->diff($this->dateT0);
            $daysBetweenT0T1 = intval($intervalT0T1->format('%a'));
            
            if ($daysBetweenT0T1 == 0) {
                return 0;
            }
            
            return $sinceT0 / $daysBetweenT0T1 * 100;
            
        }
        
        return null;
    }

    /**
     * @return string
     */
    public function getPhotoImplantation()
    {
        return $this->photoImplantation;
    }

    /**
     *
     * @param string $photoImplantation
     * @return \AppBundle\Entity\Projet
     */
    public function setPhotoImplantation($photoImplantation)
    {
        $this->photoImplantation = $photoImplantation;
        return $this;
    }

    /**
     * @return File|\Symfony\Component\HttpFoundation\File\UploadedFile|null
     */
    public function getPhotoImplantationFile()
    {
        return $this->photoImplantationFile;
    }

    /**
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile $photoImplantation
     *
     * @return $this
     */
    public function setPhotoImplantationFile(File $photoImplantation = null)
    {
        $this->photoImplantationFile = $photoImplantation;
        if ($photoImplantation) {
            if ($photoImplantation instanceof UploadedFile) {
                $this->photoImplantationOriginalName = $photoImplantation->getClientOriginalName();
            }
        }
        return $this;
    }

    /**
     * @return string
     */
    public function getPhotoImplantationOriginalName()
    {
        return $this->photoImplantationOriginalName;
    }

    /**
     * @param string $photoImplantationOriginalName
     * @return \AppBundle\Entity\Projet
     */
    public function setPhotoImplantationOriginalName($photoImplantationOriginalName)
    {
        $this->photoImplantationOriginalName = $photoImplantationOriginalName;
        return $this;
    }

    /**
     *
     * @param string $titreImplantation
     * @return \AppBundle\Entity\Projet
     */
    public function setTitreImplantation($titreImplantation)
    {
        $this->titreImplantation = $titreImplantation;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitreImplantation()
    {
        return $this->titreImplantation;
    }

    /**
     * @return string
     */
    public function getTypeImplantation()
    {
        return $this->typeImplantation;
    }

    /**
     *
     * @param string $typeImplantation
     * @return \AppBundle\Entity\Projet
     */
    public function setTypeImplantation($typeImplantation)
    {
        $this->typeImplantation = $typeImplantation;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getContrat()
    {
        return $this->contrat;
    }

    /**
     * @param string $contrat
     * @return \AppBundle\Entity\Projet
     */
    public function setContrat($contrat)
    {
        $this->contrat = $contrat;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getDebouche()
    {
        return $this->debouche;
    }

    /**
     * @param string $debouche
     * @return \AppBundle\Entity\Projet
     */
    public function setDebouche($debouche)
    {
        $this->debouche = $debouche;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTarif()
    {
        return $this->tarif;
    }

    /**
     * @param string $tarif
     * @return \AppBundle\Entity\Projet
     */
    public function setTarif($tarif)
    {
        $this->tarif = $tarif;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getTechnologie()
    {
        return $this->technologie;
    }

    /**
     * @param string $technologie
     * @return \AppBundle\Entity\Projet
     */
    public function setTechnologie($technologie)
    {
        $this->technologie = $technologie;
        return $this;
    }
    
    /**
     * @return string
     */
    public function getEquipement()
    {
        return $this->equipement;
    }

    /**
     * @param string $equipement
     * @return \AppBundle\Entity\Projet
     */
    public function setEquipement($equipement)
    {
        $this->equipement = $equipement;
        return $this;
    }

    /**
     * @return int
     */
    public function getSurfaceUtile()
    {
        return $this->surfaceUtile;
    }

    /**
     * @param int $surfaceUtile
     * @return \AppBundle\Entity\Projet
     */
    public function setSurfaceUtile($surfaceUtile)
    {
        $this->surfaceUtile = $surfaceUtile;
        return $this;
    }

    /**
     * @return int
     */
    public function getVoiries()
    {
        return floatval($this->voiries);
    }

    /**
     * @param int $voiries
     * @return \AppBundle\Entity\Projet
     */
    public function setVoiries($voiries)
    {
        $this->voiries = $voiries;
        return $this;
    }

    /**
     * @return int
     */
    public function getLineaire()
    {
        return floatval($this->lineaire);
    }

    /**
     * @param int $lineaire
     * @return \AppBundle\Entity\Projet
     */
    public function setLineaire($lineaire)
    {
        $this->lineaire = $lineaire;
        return $this;
    }

    /**
     * @return int
     */
    public function getInterdistance()
    {
        return floatval($this->interdistance);
    }

    /**
     * @param int $interdistance
     * @return \AppBundle\Entity\Projet
     */
    public function setInterdistance($interdistance)
    {
        $this->interdistance = $interdistance;
        return $this;
    }

    /**
     * @return int
     */
    public function getUnite()
    {
        return floatval($this->unite);
    }

    /**
     * @param int $unite
     * @return \AppBundle\Entity\Projet
     */
    public function setUnite($unite)
    {
        $this->unite = $unite;
        return $this;
    }

    /**
     * @return float
     */
    public function getPuissanceUnitaire()
    {
        return floatval($this->puissanceUnitaire);
    }

    /**
     * @param string $puissanceUnitaire
     * @return \AppBundle\Entity\Projet
     */
    public function setPuissanceUnitaire($puissanceUnitaire)
    {
        $this->puissanceUnitaire = $puissanceUnitaire;
        return $this;
    }

    /**
     * @return float
     */
    public function getPuissanceTotale()
    {
        return floatval($this->puissanceTotale);
    }

    /**
     * @param string $puissanceTotale
     * @return \AppBundle\Entity\Projet
     */
    public function setPuissanceTotale($puissanceTotale)
    {
        $this->puissanceTotale = $puissanceTotale;
        return $this;
    }

    /**
     * @return float
     */
    public function getProduction()
    {
        return floatval($this->production);
    }

    /**
     * @param string $production
     * @return \AppBundle\Entity\Projet
     */
    public function setProduction($production)
    {
        $this->production = $production;
        return $this;
    }

    /**
     * @return float
     */
    public function getEmprise()
    {
        return floatval($this->emprise);
    }

    /**
     * @param string $emprise
     * @return \AppBundle\Entity\Projet
     */
    public function setEmprise($emprise)
    {
        $this->emprise = $emprise;
        return $this;
    }

    /**
     * @return int
     */
    public function getCompletude()
    {
        return $this->completude;
    }

    /**
     * @param int $completude
     * @return \AppBundle\Entity\Projet
     */
    public function setCompletude($completude)
    {
        $this->completude = $completude;
        return $this;
    }

    /**
     * @return Liste
     */
    public function getListe()
    {
        return $this->liste;
    }

    /**
     * @param Liste $liste
     * @return \AppBundle\Entity\Projet
     */
    public function setListe(Liste $liste)
    {
        $this->liste = $liste;
        return $this;
    }

    /**
     * @return bool
     */
    public function isArchived()
    {
        return $this->archived;
    }

    /**
     * @param bool $archived
     * @return $this
     */
    public function setArchived($archived)
    {
        $this->archived = $archived;
        return $this;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function calculeCompletude()
    {
        $this->completude = 2; // locatisation + contact
        if(($this->terrain && $this->terrain->isNotEmpty()) || ($this->batimentExistant && $this->batimentExistant->isNotEmpty())) $this->completude++;
        if($this->typeImplantation || $this->titreImplantation || $this->contrat || $this->potentiel) $this->completude++;
        if(!$this->parcelles->isEmpty()) {
            foreach($this->parcelles as $parcelle) {
                if($parcelle->getNom()) {
                    $this->completude++;
                    break;
                }
            }
        }
        if(!$this->proprietaires->isEmpty()) {
            foreach($this->proprietaires as $proprietaire) {
                if($proprietaire->getParcelles()) {
                    $this->completude++;
                    break;
                }
            }
        }
        if(!$this->etats->isEmpty()) $this->completude++;
        if(!$this->enjeuxs->isEmpty()) {
            foreach($this->enjeuxs as $enjeux) {
                if($enjeux->getEnjeux()) {
                    $this->completude++;
                    break;
                }
            }
        }
        if(!$this->taches->isEmpty()) $this->completude++;
        if(!$this->concertations->isEmpty()) {
            foreach($this->concertations as $concertation) {
                if($concertation->getObjet()) {
                    $this->completude++;
                    break;
                }
            }
        }
        if(!$this->finances->isEmpty()) {
            foreach($this->finances as $finance) {
                if($finance->getTitre()) {
                    $this->completude++;
                    break;
                }
            }
        }
        if(!$this->documents->isEmpty()) $this->completude++;
        if(!$this->notes->isEmpty()) $this->completude++;
        
        $this->completude = round($this->completude * 100 / 13);
        return $this->completude;
    }
    
    /**
     * @return string
     */
    public function __toString()
    {
        return $this->id ? str_replace('_id', '_'.$this->id, $this->denomination) : $this->denomination;
    }
    
    public function getOptionValue($option)
    {
        switch ($option) {
            
            case 'date_creation':
                return $this->createdAt->format('m/d/Y');
            case 'date_maj':
                return $this->updatedAt->format('m/d/Y');
            case 'type_projet':
                return $this->typeProjet;
            case 'type_site':
                return $this->typeSite;
            case 'origine':
                return (string) $this->origine;
            case 'chef_projet':
                return (string) $this->chefProjet;
            case 'partenaire':
                return (string) $this->partenaire;
            case 'denomination':
                return $this->denomination;
            case 'region':
                return (string) $this->departement->getRegion();
            case 'departement':
                return (string) $this->departement;
            case 'commune':
                return $this->getCommunesInline();
            case 'latitude':
                return $this->latitude;
            case 'longitude':
                return $this->longitude;
            case 'environnement':
                return \AppBundle\Model\Environnement::getName($this->environnement);
            case 'potentiel':
                return $this->potentiel;
            case 'progression':
                return \AppBundle\Model\Progression::getName($this->progression);
            case 'date_t0':
                if ($this->dateT0 != null) {
                    return $this->dateT0->format('m/d/Y');
                }
                return '';
            case 'date_t1':
                if ($this->dateT1 != null) {
                    return $this->dateT1->format('m/d/Y');
                }
                return '';
            case 'commentaires':
                return $this->commentaires;
            case 'engage':
                return $this->getMontantEngage();
            case 'paye':
                return $this->getMontantPaye();
            default:
                return '';
        }
    }
}

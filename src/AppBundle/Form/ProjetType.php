<?php

namespace AppBundle\Form;

use AppBundle\Entity\Projet;
use AppBundle\Model\Technologie;
use AppBundle\Form\EventListener\AddCommuneFieldSubscriber as communeSubscriber;
use AppBundle\Form\EventListener\AddMairieFieldSubscriber as mairieSubscriber;
use AppBundle\Form\Extension\DatePickerType;
use AppBundle\Form\Option\AvisMairieType;
use AppBundle\Form\Option\EnvironnementType;
use AppBundle\Form\Option\FoncierType;
use AppBundle\Form\Option\ProgressionType;
use AppBundle\Form\Option\PhaseType;
use AppBundle\Form\Option\ServitudeType;
use AppBundle\Repository\UserRepository;
use AppBundle\Repository\BatimentRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProjetType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new communeSubscriber($this->entityManager));
        $builder->addEventSubscriber(new mairieSubscriber($this->entityManager));

        $builder
            ->add('archived', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => 0,
                    'Archivé' => 1,
                ],
            ])
            ->add('dateCreation', DatePickerType::class, [
                'label' => 'Date création',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => true,
            ])
            ->add('typeProjet', ChoiceType::class, [
                'label' => 'Type de projet',
                'choices' => array_flip(Projet::getTypeProjetList()),
                'required' => true,
            ])
            ->add('typeSite', ChoiceType::class, [
                'label' => 'Type de Bien',
                'choices' => array_flip(Projet::getTypeSiteList()),
                'required' => true,
            ])
            ->add('origine', EntityType::class, [
                'class' => 'AppBundle:User',
                'required' => true,
                'label' => 'Origine',
                'query_builder' => function (UserRepository $er) {
                    return $er->getFindAllQueryBuilder();
                },
            ])
            ->add('origineTelephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('chefProjet', EntityType::class, [
                'class' => 'AppBundle:User',
                'required' => false,
                'label' => 'Chef projet',
                'query_builder' => function (UserRepository $er) {
                    return $er->getFindAllQueryBuilder();
                },
            ])
            ->add('chefProjetTelephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('partenaire', EntityType::class, [
                'class' => 'AppBundle:User',
                'required' => false,
                'label' => 'Partenaire',
                'query_builder' => function (UserRepository $er) {
                    return $er->getFindAllQueryBuilder();
                },
            ])
            ->add('partenaireTelephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('mairie', EntityType::class, [
                'class' => 'AppBundle:Mairie',
                'required' => false,
                'label' => 'Mairie',
                'choices' => array(),
                'multiple' => false,
            ])
            ->add('mairieTelephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('denomination', TextType::class, [
                'label' => 'Dénomination',
                'required' => true,
            ])
            ->add('departement', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => true,
                'label' => 'Département',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.nom', 'ASC');
                },
            ])
            ->add('communes', EntityType::class, [
                'required' => true,
                'label' => 'Communes',
                'class' => 'AppBundle:Commune',
                'choices' => array(),
                'multiple' => true,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse postale',
                'required' => false,
            ])
            ->add('latitude', NumberType::class, [
                'label' => 'Latitude',
                'scale' => 10,
            ])
            ->add('longitude', NumberType::class, [
                'label' => 'Longitude',
                'scale' => 10,
            ])
            ->add('environnement', EnvironnementType::class, [
                'label' => 'Type de milieu'
            ])
            ->add('potentiel', NumberType::class, [
                'label' => 'Potentiel (MW)',
                'scale' => 3,
            ])
            /* ->add('progression', ProgressionType::class, [
                'label' => 'État'
            ])
            ->add('phase', PhaseType::class, [
                'label' => 'Phase'
            ]) */
            ->add('commentaires', TextareaType::class, [
                'label' => 'Commentaires',
                'required' => false,
                'attr' => [
                    'rows' => 5,
                ]
            ])
            ->add('finances', CollectionType::class, [
                'entry_type' => FinanceType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
            ->add('proprietaires', CollectionType::class, [
                'entry_type' => ProprietaireType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => false,
                'by_reference' => false,
            ])
            ->add('terrain', TerrainType::class, [
                'label' => 'Terrain'
            ])
            ->add('batimentExistant', BatimentType::class, [
                'label' => 'Bâtiment Existant'
            ])
            ->add('batimentNouveau', ChoiceType::class, [
                'label' => 'Modèle',
                'choices' => array_flip(Projet::getBatimentList()),
                'required' => false,
            ])
            ->add('photoEsquisseFile', FileType::class, [
                'required' => false,
                'label' => 'Esquisse',
            ])
            ->add('photoAvantFile', FileType::class, [
                'required' => false,
                'label' => 'Avant Projet',
            ])
            ->add('photoDefinitifFile', FileType::class, [
                'required' => false,
                'label' => 'Projet définitif',
            ])
            ->add('contrat', ChoiceType::class, [
                'label' => 'Contrat',
                'required' => false,
                'choices' => array_flip(Projet::getContratList()),
            ])
            ->add('debouche', ChoiceType::class, [
                'label' => 'Débouché',
                'required' => false,
                'choices' => array_flip(Projet::getDeboucheList()),
            ])
            ->add('technologie', ChoiceType::class, [
                'label' => 'Technologie',
                'choices' => array_flip(Technologie::getTechnologieList()),
                'required' => true,
            ])
            ->add('equipement', ChoiceType::class, [
                'label' => 'Equipement',
                'choices' => array_flip(Technologie::getEquipementList()),
                'required' => true,
            ])
            ->add('surfaceUtile', NumberType::class, [
                'label' => 'Surface Utile (SU)',
                'required' => false,
            ])
            ->add('unite', NumberType::class, [
                'label' => 'Unité (NB)',
                'required' => false,
                'scale' => 3,
            ])
            ->add('puissanceUnitaire', NumberType::class, [
                'label' => 'Puissance Unitaire (PU)',
                'required' => false,
                'scale' => 3,
            ])
            ->add('puissanceTotale', NumberType::class, [
                'label' => 'Puissance Totale (PT)',
                'required' => false,
                'scale' => 3,
            ])
            ->add('production', NumberType::class, [
                'label' => 'Production (PROD)',
                'required' => false,
                'scale' => 3,
            ])
            ->add('emprise', NumberType::class, [
                'label' => 'Emprise',
                'required' => false,
                'scale' => 3,
            ])
            ->add('enjeuxs', CollectionType::class, [
                'entry_type' => EnjeuxType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Enjeux',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('etats', CollectionType::class, [
                'entry_type' => EtatType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Etat',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('taches', CollectionType::class, [
                'entry_type' => TacheType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Tache',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('concertations', CollectionType::class, [
                'entry_type' => ConcertationType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Concertation',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('documents', CollectionType::class, [
                'entry_type' => DocumentType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Document',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('parcelles', CollectionType::class, [
                'entry_type' => ParcelleType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Parcelle',
                'required' => false,
                'by_reference' => false,
            ])
            ->add('notes', CollectionType::class, [
                'entry_type' => NoteType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'label' => 'Note',
                'required' => false,
                'by_reference' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Projet',
        ]);
    }
}

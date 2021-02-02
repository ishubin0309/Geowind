<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ParcEolienType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('id', TextType::class, [
                'label' => 'ID',
                'disabled' => true,
            ])
            ->add('region', TextType::class, [
                'label' => 'Région',
                'disabled' => true,
            ])
            ->add('departement', TextType::class, [
                'label' => 'Département',
                'disabled' => true,
            ])
            ->add('commune', TextType::class, [
                'label' => 'Commune',
                'disabled' => true,
            ])
            ->add('latitude', TextType::class, [
                'label' => 'Latitude',
                'disabled' => true,
            ])
            ->add('longitude', TextType::class, [
                'label' => 'Longitude',
                'disabled' => true,
            ])
            ->add('denomination', TextType::class, [
                'label' => 'Dénomination',
                'required' => false,
            ])
            ->add('miseEnService', TextType::class, [
                'label' => 'Mise en service',
                'required' => false,
            ])
            ->add('typeMachine', TextType::class, [
                'label' => 'Type de machine',
                'required' => false,
            ])
            ->add('puissanceNominaleUnitaire', NumberType::class, [
                'label' => 'Puissance nominale unitaire',
                'required' => false,
                'scale' => 6, 
            ])
            ->add('puissanceNominaleTotale', NumberType::class, [
                'label' => 'Puissance nominale totale',
                'required' => false,
                'scale' => 6, 
            ])
            ->add('productibleEstime', NumberType::class, [
                'label' => 'Productible estimé',
                'required' => false,
                'scale' => 6, 
            ])
            ->add('developpeur', TextType::class, [
                'label' => 'Développeur',
                'required' => false,
            ])
            ->add('operateur', TextType::class, [
                'label' => 'Opérateur',
                'required' => false,
            ])
            ->add('nomContact', TextType::class, [
                'label' => 'Nom contact',
                'required' => false,
            ])
            ->add('telephoneContact', TextType::class, [
                'label' => 'Téléphone contact',
                'required' => false,
            ])
            ->add('emailContact', EmailType::class, [
                'label' => 'Email contact',
                'required' => false,
            ])
            ->add('documentFile', FileType::class, [
                'required' => false,
                'label' => 'Document',
            ])
            ->add('description', TextareaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ParcEolien',
        ]);
    }
}

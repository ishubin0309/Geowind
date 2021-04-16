<?php

namespace AppBundle\Form;

use AppBundle\Entity\Terrain;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class TerrainType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('topographie', ChoiceType::class, [
                'label' => 'Topographie',
                'required' => false,
                'choices' => array_flip(Terrain::getTopographieList()),
            ])
            ->add('altitude', TextType::class, [
                'label' => 'Altitude',
                'required' => false,
            ])
            ->add('exposition', TextType::class, [
                'label' => 'Exposition',
                'required' => false,
            ])
            ->add('gestionnaire', TextType::class, [
                'label' => 'Gestionnaire',
                'required' => false,
            ])
            ->add('nomPoste', TextType::class, [
                'label' => 'Nom de poste',
                'required' => false,
            ])
            ->add('distancePdl', TextType::class, [
                'label' => 'Distance PDL',
                'required' => false,
            ])
            ->add('documentUrbanisme', ChoiceType::class, [
                'label' => 'Document',
                'required' => false,
                'choices' => array_flip(Terrain::getDocumentUrbanismeList()),
            ])
            ->add('zonage', ChoiceType::class, [
                'label' => 'Zonage',
                'required' => false,
                'choices' => array_flip(Terrain::getZonageList()),
            ])
            ->add('etatUrbanisme', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
            ->add('documentEnergie', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'multiple' => true,
                'choices' => array_flip(Terrain::getDocumentEnergieList()),
            ])
            ->add('etatEnergie', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Terrain',
        ]);
    }
}

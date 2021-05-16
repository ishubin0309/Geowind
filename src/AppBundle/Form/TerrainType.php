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
            ->add('altitude', TextType::class, [
                'label' => 'Altitude',
                'required' => false,
            ])
            ->add('relief', ChoiceType::class, [
                'label' => 'Relief',
                'required' => false,
                'choices' => array_flip(Terrain::getReliefList()),
            ])
            ->add('orientation', ChoiceType::class, [
                'label' => 'Orientation',
                'required' => false,
                'choices' => array_flip(Terrain::getOrientationList()),
            ])
            ->add('livraison', TextType::class, [
                'label' => 'Livraison (km)',
                'required' => false,
            ])
            ->add('injection', TextType::class, [
                'label' => 'Injection (km)',
                'required' => false,
            ])
            ->add('nomPoste', TextType::class, [
                'label' => 'Nom du poste',
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
                'label' => 'Document',
                'required' => false,
                'multiple' => true,
                'choices' => array_flip(Terrain::getDocumentEnergieList()),
            ])
            ->add('etatEnergie', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
            ->add('pcaet', ChoiceType::class, [
                'label' => 'PCAET',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
            ->add('tepos', ChoiceType::class, [
                'label' => 'TEPOS',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
            ->add('eoliennes', TextType::class, [
                'label' => 'Existant',
                'required' => false,
            ])
            ->add('vitesseVent', TextType::class, [
                'label' => 'Vitesse de vent (m/s)',
                'required' => false,
            ])
            ->add('productibleSolaire', TextType::class, [
                'label' => 'Productible solaire (h/an)',
                'required' => false,
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

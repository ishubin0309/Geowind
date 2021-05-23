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
                'label' => 'Altitude (m)',
                'required' => false,
            ])
            ->add('topographie', ChoiceType::class, [
                'label' => 'Topographie',
                'required' => false,
                'choices' => array_flip(Terrain::getTopographieList()),
            ])
            ->add('exposition', TextType::class, [
                'label' => 'Exposition',
                'required' => false,
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
            ->add('etatUrbanisme', ChoiceType::class, [
                'label' => 'Etat',
                'required' => false,
                'choices' => array_flip(Terrain::getEtatList()),
            ])
            ->add('zonage', ChoiceType::class, [
                'label' => 'Zonage',
                'required' => false,
                'choices' => array_flip(Terrain::getZonageList()),
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
            ->add('eoliennesDepartement', TextType::class, [
                'label' => 'Existant par département',
                'required' => false,
            ])
            ->add('eoliennesCommune', TextType::class, [
                'label' => 'Existant par commune',
                'required' => false,
            ])
            ->add('vitesseVent', TextType::class, [
                'label' => 'Vitesse de vent (m/s)',
                'required' => false,
            ])
            ->add('productiblePv', TextType::class, [
                'label' => 'Productible pv (Kwh/kwc)',
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

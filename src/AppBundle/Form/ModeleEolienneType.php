<?php

namespace AppBundle\Form;

use AppBundle\Entity\ModeleEolienne;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ModeleEolienneType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class, [
                'label' => 'Marque',
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Modèle',
                'required' => true,
            ])
            ->add('pays', TextType::class, [
                'label' => 'Origine',
                'required' => false,
            ])
            ->add('puissance', TextType::class, [
                'label' => 'Puissance (Mw)',
                'required' => false,
            ])
            ->add('hauteurMat', TextType::class, [
                'label' => 'Hauteur mât (m)',
                'required' => false,
            ])
            ->add('diametreRotor', TextType::class, [
                'label' => 'Diamètre rotor (m)',
                'required' => false,
            ])
            ->add('hauteurTotale', TextType::class, [
                'label' => 'Hauteur totale (m)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ModeleEolienne',
        ]);
    }
}

<?php

namespace AppBundle\Form;

use AppBundle\Entity\ModelePanneau;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ModelePanneauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('marque', TextType::class, [
                'label' => 'Marque',
                'required' => false,
            ])
            ->add('pays', TextType::class, [
                'label' => 'Origine',
                'required' => false,
            ])
            ->add('technique', TextType::class, [
                'label' => 'Technique',
                'required' => false,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Modèle',
                'required' => true,
            ])
            ->add('puissance', TextType::class, [
                'label' => 'Puissance (Wc)',
                'required' => false,
            ])
            ->add('longeur', TextType::class, [
                'label' => 'Longeur (mm)',
                'required' => false,
            ])
            ->add('largeur', TextType::class, [
                'label' => 'Largeur (mm)',
                'required' => false,
            ])
            ->add('epaisseur', TextType::class, [
                'label' => 'Epaisseur (mm)',
                'required' => false,
            ])
            ->add('poids', TextType::class, [
                'label' => 'Poids (kg)',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\ModelePanneau',
        ]);
    }
}

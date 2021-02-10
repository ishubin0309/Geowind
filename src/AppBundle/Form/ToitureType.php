<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ToitureType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Désignation',
                'required' => false,
            ])
            ->add('exposition', TextType::class, [
                'label' => 'Exposition (deg)',
                'required' => false,
            ])
            ->add('hautPente', TextType::class, [
                'label' => 'Haut de pente (m)',
                'required' => false,
            ])
            ->add('basPente', TextType::class, [
                'label' => 'Bas  de pente (m)',
                'required' => false,
            ])
            ->add('pente', TextType::class, [
                'label' => 'Pente calculée (%)',
                'required' => false,
            ])
            ->add('longeur', TextType::class, [
                'label' => 'Longeur (m)',
                'required' => false,
            ])
            ->add('largeur', TextType::class, [
                'label' => 'Largeur (m)',
                'required' => false,
            ])
            ->add('surfaceTotale', TextType::class, [
                'label' => 'Surface totale (m2)',
                'required' => false,
            ])
            ->add('surfaceUtile', TextType::class, [
                'label' => 'Surface utile (m2)',
                'required' => false,
            ])
            ->add('entraxe', TextType::class, [
                'label' => 'Entraxe (m)',
                'required' => false,
            ])
            ->add('photoFile', FileType::class, [
                'label' => 'Photo',
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'image/jpeg',
                            'image/png',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid Image document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Toiture',
        ]);
    }
}

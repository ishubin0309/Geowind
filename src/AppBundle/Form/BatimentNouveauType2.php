<?php

namespace AppBundle\Form;

use AppBundle\Form\Extension\DatePickerType;
use AppBundle\Form\Option\MissionType;
use AppBundle\Form\Option\NiveauType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class BatimentNouveauType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isEnabled', ChoiceType::class, [
                'label' => 'Statut',
                'choices' => [
                    'Actif' => 1,
                    'Archivé' => 0,
                ],
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('pans', TextType::class, [
                'label' => 'Pans',
                'required' => false,
            ])
            ->add('longeur', TextType::class, [
                'label' => 'Longeur',
                'required' => false,
            ])
            ->add('largeur', TextType::class, [
                'label' => 'Largeur',
                'required' => false,
            ])
            ->add('faitage', TextType::class, [
                'label' => 'Faitage',
                'required' => false,
            ])
            ->add('surfaceSol', TextType::class, [
                'label' => 'Surface au sol',
                'required' => false,
            ])
            ->add('structure', TextType::class, [
                'label' => 'Structure',
                'required' => false,
            ])
            ->add('couverture', TextType::class, [
                'label' => 'Couverture',
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
            'data_class' => 'AppBundle\Entity\Batiment',
        ]);
    }
}

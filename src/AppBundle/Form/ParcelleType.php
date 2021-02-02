<?php

namespace AppBundle\Form;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ParcelleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Parcelle',
                'required' => false,
            ])
            ->add('departement', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => false,
                'label' => 'Département',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                        ->orderBy('d.nom', 'ASC');
                },
            ])
            ->add('commune', TextType::class, [
                'required' => false,
                'label' => 'Commune',
                // 'choices' => array(),
            ])
            ->add('lieuDit', TextType::class, [
                'label' => 'Lieu-dit',
                'required' => false,
            ])
            ->add('surface', TextType::class, [
                'label' => 'Surface (m²)',
                'required' => false,
            ])
            ->add('note', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Parcelle',
        ]);
    }
}

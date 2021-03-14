<?php

namespace AppBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class RappelDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('donnee', TextType::class, [
                'label' => 'Donnée',
                'required' => true,
            ])
            ->add('type', TextType::class, [
                'label' => 'Type',
                'required' => false,
            ])
            ->add('note', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ])
            ->add('order', NumberType::class, [
                'label' => 'Order',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\RappelData',
        ]);
    }
}

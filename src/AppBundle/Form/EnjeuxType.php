<?php

namespace AppBundle\Form;

use AppBundle\Entity\Enjeux;
use AppBundle\Model\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class EnjeuxType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('facteur', ChoiceType::class, [
                'label' => 'Facteur',
                'choices' => array_flip(Enjeux::getFacteurList()),
                'required' => true,
            ])
            ->add('enjeux', ChoiceType::class, [
                'label' => 'Enjeux',
                'required' => false,
                'choices' => array_flip(Etat::getDynamiqueList()),
            ])
            ->add('risque', TextType::class, [
                'label' => 'Risque',
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
            'data_class' => 'AppBundle\Entity\Enjeux',
        ]);
    }
}

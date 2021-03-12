<?php

namespace AppBundle\Form;

use AppBundle\Model\Tache;
use AppBundle\Model\Etat;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DatePickerType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('objet', ChoiceType::class, [
                'label' => 'Objet',
                'required' => true,
                'choices' => array_flip(Tache::getObjetList()),
            ])
            ->add('etat', ChoiceType::class, [
                'label' => 'Tache',
                'required' => true,
                'choices' => array_flip(Tache::getTacheList()),
            ])
            /* ->add('dynamique', ChoiceType::class, [
                'label' => 'Dynamique',
                'choices' => array_flip(Etat::getDynamiqueList()),
            ]) */
            ->add('note', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Tache',
        ]);
    }
}

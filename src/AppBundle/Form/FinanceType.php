<?php

namespace AppBundle\Form;

use AppBundle\Model\Etat;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class FinanceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('phase', ChoiceType::class, [
                'label' => 'Phase',
                'required' => false,
                'choices' => array_flip(Etat::getPhaseList()),
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'required' => true,
            ])
            ->add('montantTotal', MoneyType::class, [
                'label' => 'Total',
                'scale' => 2,
            ])
            ->add('montantEngage', MoneyType::class, [
                'label' => 'Engagé',
                'scale' => 2,
            ])
            ->add('montantPaye', MoneyType::class, [
                'label' => 'Payé',
                'scale' => 2,
            ])
            ->add('montantRestant', MoneyType::class, [
                'label' => 'Restant Dû',
                'scale' => 2,
            ])
            ->add('bureau', EntityType::class, [
                'class' => 'AppBundle:Bureau',
                'required' => true,
                'label' => 'Prestataire',
            ])
            ->add('dateEngmt', DatePickerType::class, [
                'label' => 'Date de commande',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => true,
            ])
            ->add('dateEcheance', DatePickerType::class, [
                'label' => 'Date d’échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('duplique', TextType::class, [
                'label' => 'Dupliquée',
                'required' => false,
            ])
            /* ->add('note', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ]) */
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Finance',
        ]);
    }
}

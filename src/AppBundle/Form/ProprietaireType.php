<?php

namespace AppBundle\Form;

use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class ProprietaireType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('parcelles', TextType::class, [
                'label' => 'Parcelles',
                'required' => true,
            ])
            ->add('proprietaire', TextType::class, [
                'label' => 'Propriétaire',
                'required' => true,
            ])
            ->add('telephoneProprietaire', TextType::class, [
                'label' => 'Téléphone propriétaire',
                'required' => false,
            ])
            ->add('adresseProprietaire', TextType::class, [
                'label' => 'Adresse propriétaire',
                'required' => false,
            ])
            ->add('emailProprietaire', EmailType::class, [
                'label' => 'Email propriétaire',
                'required' => false,
            ])
            ->add('accordProprietaire', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('dateSignatureProprietaire', DatePickerType::class, [
                'label' => 'Date signature propriétaire',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceProprietaire', DatePickerType::class, [
                'label' => 'Date échéance propriétaire',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceProprietaire', DatePickerType::class, [
                'label' => 'Date naissance propriétaire',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('lieuNaissanceProprietaire', TextType::class, [
                'label' => 'Lieu naissance propriétaire',
                'required' => false,
            ])
            ->add('civiliteProprietaire', ChoiceType::class, [
                'label' => 'Civilité propriétaire',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr', 
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('exploitant', TextType::class, [
                'label' => 'Exploitant',
                'required' => false,
            ])
            ->add('telephoneExploitant', TextType::class, [
                'label' => 'Téléphone exploitant',
                'required' => false,
            ])
            ->add('adresseExploitant', TextType::class, [
                'label' => 'Adresse exploitant',
                'required' => false,
            ])
            ->add('emailExploitant', EmailType::class, [
                'label' => 'Email exploitant',
                'required' => false,
            ])
            ->add('accordExploitant', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('dateSignatureExploitant', DatePickerType::class, [
                'label' => 'Date signature exploitant',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceExploitant', DatePickerType::class, [
                'label' => 'Date échéance exploitant',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceExploitant', DatePickerType::class, [
                'label' => 'Date naissance exploitant',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('lieuNaissanceExploitant', TextType::class, [
                'label' => 'Lieu naissance exploitant',
                'required' => false,
            ])
            ->add('civiliteExploitant', ChoiceType::class, [
                'label' => 'Civilité exploitant',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr', 
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Proprietaire',
        ]);
    }
}

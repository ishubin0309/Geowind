<?php

namespace AppBundle\Form;

use AppBundle\Entity\News;
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
class NewsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateSaisie', DatePickerType::class, [
                'label' => 'Date Saisie',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateParution', DatePickerType::class, [
                'label' => 'Date Parution',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('saisie', TextType::class, [
                'label' => 'Saisie',
                'required' => false,
            ])
            ->add('theme', ChoiceType::class, [
                'label' => 'Thème',
                'required' => true,
                'choices' => array_flip(News::getThemeList()),
            ])
            ->add('filiere', ChoiceType::class, [
                'label' => 'Filière',
                'required' => false,
                'choices' => array_flip(News::getFiliereList()),
            ])
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'required' => false,
            ])
            ->add('note', TextType::class, [
                'label' => 'Note',
                'required' => false,
            ])
            ->add('url', TextType::class, [
                'label' => 'URL',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\News',
        ]);
    }
}

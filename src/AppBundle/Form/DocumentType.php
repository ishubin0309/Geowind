<?php

namespace AppBundle\Form;

use AppBundle\Entity\Document;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextAreaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class DocumentType extends AbstractType
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
            ->add('type', ChoiceType::class, [
                'label' => 'Type',
                'required' => false,
                'choices' => array_flip(Document::getTypeList()),
            ])
            ->add('titre', TextAreaType::class, [
                'label' => 'Titre',
                'required' => false,
            ])
            ->add('documentFile', FileType::class, [
                'label' => 'Fichier',
                'required' => false,
            ])
            ->add('description', TextAreaType::class, [
                'label' => 'Description',
                'required' => false,
            ])
            ->add('plan', CheckboxType::class, [
                'label' => ' ',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Document',
        ]);
    }
}

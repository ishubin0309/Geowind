<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class MessageParcellesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', EmailType::class, [
                'label' => 'Expéditeur',
                'disabled' => true,
            ])
            ->add('to', EmailType::class, [
                'label' => 'Destinataire',
                'required' => true,
            ])
            ->add('object', TextType::class, [
                'label' => 'Sujet',
                'required' => true,
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'rows' => 15,
                ]
            ])
            ->add('documentFile', FileType::class, [
                'label' => 'Fichier',
                'required' => false,
            ])
            ->add('departements', TextType::class, [
                'label' => 'Departements',
                'required' => false
            ])
            ->add('communes', TextType::class, [
                'label' => 'Communes',
                'required' => false
            ])
            ->add('parcelles', TextType::class, [
                'label' => 'Parcelles',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\MessageParcelles',
        ]);
    }
}

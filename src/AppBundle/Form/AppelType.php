<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class AppelType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('from', TextType::class, [
                'label' => 'Enquêteur',
                'disabled' => true,
            ])
            ->add('to', TextType::class, [
                'label' => 'Interlocuteur',
                'required' => true,
            ])
            /* ->add('replyTo', EmailType::class, [
                'label' => 'Répondre à',
                'required' => true,
            ]) */
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
            ->add('result', ChoiceType::class, [
                'label' => 'Résultat',
                'required' => true,
                'choices' => [
                    '?' => '?',
                    '+' => '+',
                    '-' => '-',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Appel',
        ]);
    }
}

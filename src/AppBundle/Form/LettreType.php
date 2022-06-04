<?php

namespace AppBundle\Form;

use AppBundle\Form\EventListener\AddLettreProjetFieldSubscriber as projetSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
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
class LettreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->addEventSubscriber(new projetSubscriber($this->entityManager));
        $builder
            ->add('from', TextType::class, [
                'label' => 'Enquêteur',
                'disabled' => true,
            ])
            ->add('to', TextareaType::class, [
                'label' => 'Destinataire',
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
            ->add('result', ChoiceType::class, [
                'label' => 'Résultat',
                'required' => true,
                'choices' => [
                    '?' => '?',
                    '+' => '+',
                    '-' => '-',
                    'R' => 'R',
                ],
            ])
            ->add('projet', EntityType::class, [
                'class' => 'AppBundle:Projet',
                'required' => false,
                'label' => 'Projet',
                'choices' => array(),
                'multiple' => false,
            ])
            ->add('body', TextareaType::class, [
                'label' => 'Message',
                'required' => true,
                'attr' => [
                    'rows' => 15,
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Lettre',
        ]);
    }
}

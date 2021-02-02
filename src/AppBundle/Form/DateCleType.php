<?php

namespace AppBundle\Form;

use AppBundle\Entity\DateCle;
use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class DateCleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DatePickerType::class, [
                'label' => 'Date',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => true,
            ])
            ->add('code', ChoiceType::class, [
                'label' => 'Titre',
                'required' => true,
                'choices' => array_flip(DateCle::getCodeList()),
            ])
            ->add('description', TextType::class, [
                'label' => 'Description autres dates',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\DateCle',
        ]);
    }
}

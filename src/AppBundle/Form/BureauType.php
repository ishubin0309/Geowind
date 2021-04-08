<?php

namespace AppBundle\Form;

use AppBundle\Repository\UserRepository;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class BureauType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Dénomination',
                'required' => true,
            ])
            ->add('representant', TextType::class, [
                'label' => 'Chargé d\'études',
                'required' => false,
            ])
            ->add('adresse', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Adresse email',
                'required' => false,
            ])
            ->add('partenaires', EntityType::class, [
                'class' => 'AppBundle:User',
                'required' => false,
                'multiple' => true,
                'label' => 'Partenaires',
                'query_builder' => function (EntityRepository $er) {
                    // return $er->createQueryBuilder('u');
                    return $er->createQueryBuilder('u')
                    ->join('u.departements', 'd');
                },
            ])
            ->add('details', TextareaType::class, [
                'label' => 'Détails',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Bureau',
        ]);
    }
}

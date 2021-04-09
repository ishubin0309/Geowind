<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'required' => true,
            ])
            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'required' => true,
            ])
            ->add('username', TextType::class, [
                'label' => 'User',
                'required' => true,
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email',
                'required' => true,
            ])
            ->add('plainPassword', PasswordType::class, [
                'label' => 'Mot de passe',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
            ])
            ->add('departements', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => false,
                'multiple' => true,
                'label' => 'Secteurs (Partenaire)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.nom', 'ASC');
                },
            ])
            ->add('departementsChefProjet', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => false,
                'multiple' => true,
                'label' => 'Secteurs (Chef projet)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.nom', 'ASC');
                },
            ])
            ->add('departementsChargeFoncier', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => false,
                'multiple' => true,
                'label' => 'Secteurs (Chargé foncier)',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('d')
                    ->orderBy('d.nom', 'ASC');
                },
            ])
            ->add('roles', ChoiceType::class, [
                'choices' => array_flip(User::getRolesList()),
                'label' => 'Droits',
                'multiple' => true,
                'expanded' => true,
                'required' => true,
            ])
            ->add('sendCredentials', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Envoyer les identifiants',
                'required' => true,
            ])
            ->add('sendSecteurs', ChoiceType::class, [
                'choices' => [
                    'Oui' => true,
                    'Non' => false,
                ],
                'label' => 'Inclure secteurs',
                'required' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
        ]);
    }
}

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
class UserEditType extends AbstractType
{
    private $user = 0;
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->user = $options['user'];
        $builder
            ->add('enabled', ChoiceType::class, [
                'choices' => [
                    'Compte actif' => true,
                    'Compte désactivé' => false,
                ],
                'label' => 'Etat du compte',
                'required' => true,
            ])
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
                'label' => 'Mot de passe (en cas de changement uniquement)',
                'required' => false,
            ])
            ->add('telephone', TextType::class, [
                'label' => 'Téléphone',
                'required' => true,
            ])
            ->add('departements', EntityType::class, [
                'class' => 'AppBundle:Departement',
                'required' => true,
                'multiple' => true,
                'label' => 'Secteurs',
                'query_builder' => function (EntityRepository $er) {
                    $departements = $er->getFindUsersAssignedDepartments($this->user);
                    if($departements) return $er->createQueryBuilder('d')
                    ->where('d NOT IN (:departements)')
                    ->orderBy('d.nom', 'ASC')
                    ->setParameter('departements', $departements);
                    else return $er->createQueryBuilder('d')
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
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User',
            'user' => false
        ]);
    }
}

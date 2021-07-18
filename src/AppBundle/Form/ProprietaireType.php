<?php

namespace AppBundle\Form;

use AppBundle\Form\Extension\DatePickerType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
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
                'label' => 'Bailleur',
                'required' => true,
            ])
            ->add('proprietaire2', TextType::class, [
                'label' => 'Vendeur',
                'required' => false,
            ])
            ->add('proprietaire3', TextType::class, [
                'label' => 'Vendeur',
                'required' => false,
            ])
            ->add('telephoneProprietaire', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('telephoneProprietaire2', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('telephoneProprietaire3', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('adresseProprietaire', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('adresseProprietaire2', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('adresseProprietaire3', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('emailProprietaire', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('emailProprietaire2', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('emailProprietaire3', EmailType::class, [
                'label' => 'Email',
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
            ->add('accordProprietaire2', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('accordProprietaire3', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('dateSignatureProprietaire', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateSignatureProprietaire2', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateSignatureProprietaire3', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceProprietaire', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceProprietaire2', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceProprietaire3', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dureeProprietaire', TextType::class, [
                'label' => 'Duree',
                'required' => false,
            ])
            ->add('dateNaissanceProprietaire', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceProprietaire2', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceProprietaire3', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('lieuNaissanceProprietaire', TextType::class, [
                'label' => 'Lieu naissance',
                'required' => false,
            ])
            ->add('lieuNaissanceProprietaire2', TextType::class, [
                'label' => 'Lieu naissance',
                'required' => false,
            ])
            ->add('lieuNaissanceProprietaire3', TextType::class, [
                'label' => 'Lieu naissance',
                'required' => false,
            ])
            ->add('civiliteProprietaire', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr', 
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('civiliteProprietaire2', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('civiliteProprietaire3', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('droitProprietaire', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier' => 'Usufruitier',
                    'Usufruitiere' => 'Usufruitiere',
                    'Nu-propriétaire' => 'Nu-propriétaire',
                    'Nue-propriétaire' => 'Nue-propriétaire',
                    'Exploitant' => 'Exploitant',
                ],
            ])
            ->add('droitProprietaire2', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier' => 'Usufruitier',
                    'Usufruitiere' => 'Usufruitiere',
                    'Nu-propriétaire' => 'Nu-propriétaire',
                    'Nue-propriétaire' => 'Nue-propriétaire',
                    'Exploitant' => 'Exploitant',
                ],
            ])
            ->add('droitProprietaire3', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier' => 'Usufruitier',
                    'Usufruitiere' => 'Usufruitiere',
                    'Nu-propriétaire' => 'Nu-propriétaire',
                    'Nue-propriétaire' => 'Nue-propriétaire',
                    'Exploitant' => 'Exploitant',
                ],
            ])
            ->add('qualiteProprietaire', ChoiceType::class, [
                'label' => 'Qualité"',
                'required' => false,
                'choices' => [
					'Société' => 'Société',
                    'Personne' => 'Personne',
                ],
            ])
            ->add('qualiteProprietaire2', ChoiceType::class, [
                'label' => 'Qualité',
                'required' => false,
                'choices' => [
					'Société' => 'Société',
					'Personne' => 'Personne',
                ],
            ])
            ->add('qualiteProprietaire3', ChoiceType::class, [
                'label' => 'Qualité',
                'required' => false,
                'choices' => [
					'Société' => 'Société',
					'Personne' => 'Personne',
                ],
            ])
            ->add('maritalProprietaire', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
                ],
            ])
            ->add('maritalProprietaire2', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
                ],
            ])
            ->add('maritalProprietaire3', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
                ],
            ])
            ->add('exploitant', TextType::class, [
                'label' => 'Exploitant',
                'required' => false,
            ])
            ->add('exploitant2', TextType::class, [
                'label' => 'Exploitant',
                'required' => false,
            ])
            ->add('exploitant3', TextType::class, [
                'label' => 'Exploitant',
                'required' => false,
            ])
            ->add('telephoneExploitant', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('telephoneExploitant2', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('telephoneExploitant3', TextType::class, [
                'label' => 'Téléphone',
                'required' => false,
            ])
            ->add('adresseExploitant', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('adresseExploitant2', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('adresseExploitant3', TextType::class, [
                'label' => 'Adresse',
                'required' => false,
            ])
            ->add('emailExploitant', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('emailExploitant2', EmailType::class, [
                'label' => 'Email',
                'required' => false,
            ])
            ->add('emailExploitant3', EmailType::class, [
                'label' => 'Email',
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
            ->add('accordExploitant2', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('accordExploitant3', ChoiceType::class, [
                'label' => 'Accord',
                'required' => false,
                'choices' => [
                    'OUI' => 'OUI',
                    'NON' => 'NON',
                    'NEGO' => 'NEGO',
                ],
            ])
            ->add('dateSignatureExploitant', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateSignatureExploitant2', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateSignatureExploitant3', DatePickerType::class, [
                'label' => 'Date signature',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceExploitant', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceExploitant2', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateEcheanceExploitant3', DatePickerType::class, [
                'label' => 'Date échéance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceExploitant', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceExploitant2', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('dateNaissanceExploitant3', DatePickerType::class, [
                'label' => 'Date naissance',
                'widget' => 'single_text',
                'format' => 'dd/MM/yyyy',
                'html5' => false,
                'required' => false,
            ])
            ->add('lieuNaissanceExploitant', TextType::class, [
                'label' => 'Lieu naissance exploitant',
                'required' => false,
            ])
            ->add('lieuNaissanceExploitant2', TextType::class, [
                'label' => 'Lieu naissance exploitant',
                'required' => false,
            ])
            ->add('lieuNaissanceExploitant3', TextType::class, [
                'label' => 'Lieu naissance exploitant',
                'required' => false,
            ])
            ->add('civiliteExploitant', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr', 
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('civiliteExploitant2', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('civiliteExploitant3', ChoiceType::class, [
                'label' => 'Civilité',
                'required' => false,
                'choices' => [
                    'Mr' => 'Mr',
                    'Mme' => 'Mme',
                    'Mlle' => 'Mlle'
                ],
            ])
            ->add('droitExploitant', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier(e)' => 'Usufruitier(e)',
                    'Nu(e)-propriétaire' => 'Nu(e)-propriétaire)',
                ],
            ])
            ->add('droitExploitant2', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier(e)' => 'Usufruitier(e)',
                    'Nu(e)-propriétaire' => 'Nu(e)-propriétaire)',
                ],
            ])
            ->add('droitExploitant3', ChoiceType::class, [
                'label' => 'Droit',
                'required' => false,
                'choices' => [
                    'Propriétaire' => 'Propriétaire',
                    'Indivisaire' => 'Indivisaire',
                    'Usufruitier(e)' => 'Usufruitier(e)',
                    'Nu(e)-propriétaire' => 'Nu(e)-propriétaire)',
                ],
            ])
            ->add('maritalExploitant', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
                ],
            ])
            ->add('maritalExploitant2', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
                ],
            ])
            ->add('maritalExploitant3', ChoiceType::class, [
                'label' => 'Marital',
                'required' => false,
                'choices' => [
                    'Célibataire' => 'Célibataire',
                    'Veuf' => 'Veuf',
                    'Veuve' => 'Veuve',
                    'Pacsé' => 'Pacsé',
                    'Pacsée' => 'Pacsée',
                    'Marié' => 'Marié',
                    'Mariée' => 'Mariée',
                    'Séparé' => 'Séparé',
                    'Séparée' => 'Séparée',
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

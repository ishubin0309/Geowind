<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * @author Haffoudhi
 */
class ImportType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('importFile', FileType::class, [
                'label' => 'Fichier',
                'required' => true,
                'constraints' => [
                    new File([
                        'maxSize' => '20m',
                        'mimeTypes' => [
                            'text/plain', 
                            'text/csv', 
                            'application/csv',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid csv document',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Import',
        ]);
    }
}

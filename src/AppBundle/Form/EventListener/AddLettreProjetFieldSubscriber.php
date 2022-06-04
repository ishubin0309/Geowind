<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Haffoudhi
 */
class AddLettreProjetFieldSubscriber implements EventSubscriberInterface
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            FormEvents::PRE_SET_DATA => 'preSetData',
            FormEvents::PRE_SUBMIT => 'preSubmit',
        ];
    }

    public function preSetData(FormEvent $event)
    {
        $lettre = $event->getData();
        $form = $event->getForm();
        
        if($lettre) $choices = [$lettre->getProjet()];
        else $choices = [];

        $form->add('projet', EntityType::class, [
            'choices' => $choices,
            'label' => 'Projet',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:Projet',
        ]);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $ids = [];
        if (array_key_exists('projet', $data)) {
            $ids[] = $data['projet'];
        }

        $choices = $this->entityManager->getRepository('AppBundle:Projet')->findById($ids);

        $form->add('projet', EntityType::class, [
            'choices' => $choices,
            'label' => 'Projet',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:Projet',
        ]);
    }
}
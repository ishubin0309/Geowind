<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Haffoudhi
 */
class AddEquipementFieldSubscriber implements EventSubscriberInterface
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
        $projet = $event->getData();
        $form = $event->getForm();

        $choices = [$projet->getEquipement()];
        // $choices = [];

        $form->add('equipement', ChoiceType::class, [
            'choices' => $choices,
            'label' => 'Modèle',
            'required' => false,
        ]);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $choices = [];
        if (array_key_exists('equipement', $data)) {
            $choices[$data['equipement']] = $data['equipement'];
        }

        $form->add('equipement', ChoiceType::class, [
            'choices' => $choices,
            'label' => 'Modèle',
            'required' => false,
        ]);
    }
}
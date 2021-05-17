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
class AddMairieFieldSubscriber implements EventSubscriberInterface
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

        $choices = [$projet->getMairie()->getNomMaire() . ' ' . $projet->getMairie()->getPrenomMaire() => $projet->getMairie()->getId()];
        // $choices = [];

        $form->add('mairie', EntityType::class, [
            'choices' => $choices,
            'label' => 'Mairie',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:mairie',
        ]);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $ids = [];
        if (array_key_exists('mairie', $data)) {
            $ids[] = $data['mairie'];
        }

        $choices = $this->entityManager->getRepository('AppBundle:Mairie')->findById($ids);

        $form->add('mairie', EntityType::class, [
            'choices' => $choices,
            'label' => 'Mairie',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:Mairie',
        ]);
    }
}
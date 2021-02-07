<?php

namespace AppBundle\Form\EventListener;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

/**
 * @author Stéphane Ear <stephaneear@gmail.com>
 */
class AddCommuneFieldSubscriber implements EventSubscriberInterface
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

        $choices = $projet->getCommunes();
        
        $form->add('communes', EntityType::class, [
            'choices' => $choices,
            'label' => 'Communes',
            'required' => true,
            'multiple' => true,
            'class' => 'AppBundle:Commune',
        ]);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $ids = [];
        if (array_key_exists('communes', $data)) {
            $ids = $data['communes'];
        }

        $choices = $this->entityManager->getRepository('AppBundle:Commune')
                    ->findById($ids);

        $form->add('communes', EntityType::class, [
            'choices' => $choices,
            'label' => 'Communes',
            'required' => true,
            'multiple' => true,
            'class' => 'AppBundle:Commune',
        ]);
    }
}
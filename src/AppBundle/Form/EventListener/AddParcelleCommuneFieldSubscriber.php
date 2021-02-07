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
class AddParcelleCommuneFieldSubscriber implements EventSubscriberInterface
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
        $parcelle = $event->getData();
        $form = $event->getForm();

        if($parcelle) 
            $choices = [$parcelle->getCommune()];
        else $choices = [$this->entityManager->getRepository('AppBundle:Commune')->findBy(['insee' => '01319'])];

        $form->add('commune', EntityType::class, [
            'choices' => $choices,
            'label' => 'Commune',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:Commune',
        ]);
    }

    public function preSubmit(FormEvent $event)
    {
        $form = $event->getForm();
        $data = $event->getData();

        $ids = [];
        if (array_key_exists('commune', $data)) {
            $ids[] = $data['commune'];
        }

        $choices = $this->entityManager->getRepository('AppBundle:Commune')->findById($ids);

        $form->add('commune', EntityType::class, [
            'choices' => $choices,
            'label' => 'Commune',
            'required' => false,
            'multiple' => false,
            'class' => 'AppBundle:Commune',
        ]);
    }
}
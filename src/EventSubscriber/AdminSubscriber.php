<?php

namespace App\EventSubscriber;

use App\Model\TimestampedInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityPersistedEvent;
use EasyCorp\Bundle\EasyAdminBundle\Event\BeforeEntityUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;


// Permet de rendre automatique l'ajout de date lors de la création d'un article
class AdminSubscriber implements EventSubscriberInterface
{
   public static function getSubscribedEvents()
   {
     return[
        //ajout des éléments qui seront exécuté avant la création d"une entité
        BeforeEntityPersistedEvent::class => ['setEntityCreatedAt'],
        BeforeEntityUpdatedEvent::class => ['setEntityUpdatedAt']
     ];
    }

    public function setEntityCreatedAt(BeforeEntityPersistedEvent $event)
    {   
        // permet de récupérer l'entité
        $entity = $event->getEntityInstance();
        //Grace à la création de l'interface Timestamped on peux créer une condition!
        if(!$entity instanceof TimestampedInterface){
            return;
        }
        // Sinon on set à la date du jour et on utilise le timezone pour avoir l'heure correcte sinon on a 2 heures de décalage
        $timezone = new \DateTimeZone('Europe/Paris');
        $entity->setCreatedAt(new \DateTime('now',  $timezone));
    }

    public function setEntityupdatedAt(BeforeEntityUpdatedEvent $event)
    {
        $entity = $event->getEntityInstance();

        if(!$entity instanceof TimestampedInterface){
            return;
        }
        $timezone = new \DateTimeZone('Europe/Paris');
        $entity->setUpdatedAt(new \DateTime('now',  $timezone));
    }
}

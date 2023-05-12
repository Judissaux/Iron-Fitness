<?php

namespace App\EventSubscriber;


use App\Model\IllustrationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * Subscriber qui permet de supprimer les images de façon automatique lors de l'édition ou de la suppression d'un élément contenant une image uploadé sur easyadmin
 */
class DeleteImageSubscriber implements EventSubscriberInterface{

    

    public function __construct(private ParameterBagInterface $parameterBag){       
    }

    public static function getSubscribedEvents(){
        return [
            AfterEntityDeletedEvent::class => ['deletePhysicalImage'],
        ];
    }

    public function deletePhysicalImage(AfterEntityDeletedEvent $event){

        $entity = $event->getEntityInstance();
        if (!$entity instanceof IllustrationInterface ){
             return;
        }

        $imgpath = $this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('medias_directory') .
        $entity->getIllustration();

      
             
        if(file_exists($imgpath)) unlink($imgpath);

    }
}
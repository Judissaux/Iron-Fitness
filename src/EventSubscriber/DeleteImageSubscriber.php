<?php

namespace App\EventSubscriber;


use App\Model\IllustrationInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityDeletedEvent;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * Subscriber qui permet de supprimer les images de façon automatique lors de l'édition ou de la suppression d'un élément contenant une image uploadé sur easyadmin
 */
class DeleteImageSubscriber implements EventSubscriberInterface{

    public function __construct(private ParameterBagInterface $parameterBag, private CacheManager $cacheManager){}

    public static function getSubscribedEvents(){
        return [
            AfterEntityDeletedEvent::class => ['deletePhysicalImage'],
        ];
    }

    //Permet de supprimer l'image de l'entité supprimée ainsi que celle en cache dans le bundle Liipimagine si elle existe
    public function deletePhysicalImage(AfterEntityDeletedEvent $event){

        $entity = $event->getEntityInstance();

        if (!$entity instanceof IllustrationInterface ){
             return;
        }
        
        $imgpath = $this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('medias_directory') .
        $entity->getIllustration();    
        
        $this->cacheManager->remove('/uploads/' .$entity->getIllustration());  

        if(file_exists($imgpath)) unlink($imgpath);
        
    }
}
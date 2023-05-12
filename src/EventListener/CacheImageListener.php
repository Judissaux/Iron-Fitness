<?php

namespace App\EventListener;


use Doctrine\ORM\Event\PostRemoveEventArgs;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
  
class CacheImageListener
{
  
   
    

    public function __construct( protected $cacheManager, private ParameterBagInterface $parameterBag)
    {
    }

    

    public function postUpdate(PostUpdateEventArgs $args)
    {  
     // on récupére l'objet en cours d'update
     $entity = $args->getObject();
     
     $this->cacheManager->remove('/uploads/' .$entity->getIllustration(), 'miniature');
        
      
    }

    //Fonction pour delete l'image du cache
    public function postRemove(PostRemoveEventArgs $args)
    {
        // on récupére l'objet supprimé
       $entity = $args->getObject(); 
       
       $this->cacheManager->remove('/uploads/' .$entity->getIllustration());

       
    }
    
 
}
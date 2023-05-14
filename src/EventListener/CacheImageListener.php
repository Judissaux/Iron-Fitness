<?php

namespace App\EventListener;

use Doctrine\ORM\Event\PreUpdateEventArgs;

/**
 * Class qui permet de supprimer l'image en cache si modification de celle-ci dans une entité
 */
class CacheImageListener
{
  
    public function __construct(protected $cacheManager)
    {}

    public function preUpdate(PreUpdateEventArgs $args)
    {
        // On vérifie si le champs 'illustration' a été modifier
        if ($args->hasChangedField('illustration')) {
            // Ici on récupére l'ancienne valeur avant persist en bdd
            $previousIllustration = $args->getOldValue('illustration');
            // On supprimer l'image du cache
            $this->cacheManager->remove('/uploads/' . $previousIllustration);
        }
        
    }
       
}
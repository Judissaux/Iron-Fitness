<?php

namespace App\EventListener;

use App\Entity\Article;
use App\Model\IllustrationInterface;
use Doctrine\ORM\Event\PostUpdateEventArgs;
use Doctrine\ORM\Event\PostPersistEventArgs;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
  
class CacheImageListener
{
  
    public function __construct(protected $cacheManager,private ParameterBagInterface $parameterBag){}
  
    // en cas la modification l'image d'origine
    public function postUpdate(PostUpdateEventArgs $args)
    {
        $entity = $args->getObject();
  
        if ($entity instanceof Article) {
            // vider le cache des vignettes
            $this->cacheManager->remove($this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('medias_directory') .$entity->getIllustration());
        }
    }
 
    // en cas du supprission l'image d'origine
    public function preRemove(PostPersistEventArgs $args)
    {
        $entity = $args->getObject();
        
        if ($entity instanceof Article) {
            // vider le cache des vignettes
            $this->cacheManager->remove($this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('medias_directory') .$entity->getIllustration());
        }
    }
 
}
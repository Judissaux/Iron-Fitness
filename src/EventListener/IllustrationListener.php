<?php

namespace App\EventListener;

use App\Model\IllustrationInterface;
use Symfony\Component\Mime\MimeTypes;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\PrePersistEventArgs;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


/**
 * Class qui permet de supprimer l'image en cache si modification de celle-ci dans une entité
 */
class IllustrationListener
{
    public function __construct(private ParameterBagInterface $parameterBag){}
  

    public function prePersist(PrePersistEventArgs $args)
    {
        
        $entity = $args->getObject();

        // Vérifiez si l'entité concerne le téléchargement de fichiers
        if ($entity instanceof IllustrationInterface ) {
            $this->validateUploadedFile($entity);
        }
            
    }

    public function preUpdate(PreUpdateEventArgs $args)
    {
        $entity = $args->getObject();

        // Vérifiez si l'entité concerne le téléchargement de fichiers
        if ($entity instanceof IllustrationInterface ) {
            $this->validateUploadedFile($entity);
        }
    }

    private function validateUploadedFile($entity)
    {
        // Récupérer le fichier téléchargé depuis l'entité
        $IllustrationFile = $entity->getIllustration();        

        $imgpath = $this->parameterBag->get('kernel.project_dir') . $this->parameterBag->get('medias_directory') .
        $IllustrationFile;
        // Valider le type MIME du fichier
        $mimeTypes = new MimeTypes();
        $mimeType = $mimeTypes->guessMimeType($imgpath);

        if ($mimeType !== 'image/jpeg' && $mimeType !== 'image/png' ) {
            throw new \Exception('Type de fichier non autorisé. Seulement "jpeg" ou "png"');            
        }

    }
       
       
}
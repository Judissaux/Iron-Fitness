<?php

namespace App\Controller\Admin;

use App\Entity\Coach;
use App\Validator\UploadTypeConstraint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class CoachCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Coach::class;
    }
  

    public function configureCrud(Crud $crud): Crud
        {
            return $crud

            ->setEntityLabelInSingular('un coach')
            ->showEntityActionsInlined()
            ->renderContentMaximized();           
            
        }
    
    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadsDir = $this->getParameter('uploads_directory');

        yield TextField::new('firstname','Prénom'); 
               
        $imageField = ImageField::new('illustration', 'Images')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ->setHelp('Seulement .png ou .jpg et max image de taille 1Mo' )
        ->setFormTypeOption(
            'constraints',
            [
                new UploadTypeConstraint([
                    'mimeTypes' => [ // We want to let upload only jpeg or png
                        'image/jpeg',
                        'image/png',
                    ],
                ])
            ]);

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $imageField->setRequired(false);
        };

        yield $imageField;
          
    }    
}


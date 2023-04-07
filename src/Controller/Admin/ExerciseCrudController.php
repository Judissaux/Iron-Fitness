<?php

namespace App\Controller\Admin;

use App\Entity\Exercise;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExerciseCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercise::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud

        ->setEntityLabelInSingular('un article')
        ->setEntityLabelInPlural('Articles')
        ->showEntityActionsInlined()
        ->renderContentMaximized();
    }


public function configureFields(string $pageName): iterable
{
   $mediaDir = $this->getParameter('medias_directory');
   $uploadsDir = $this->getParameter('uploads_directory');

    yield TextField::new('name','Nom');
    $imageField = ImageField::new('illustration', 'Images')
    ->setBasePath($uploadsDir)
    ->setUploadDir($mediaDir)
    ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');

    //Permet d'enregistrer les modifications sans devoir remettre une image
    if(Crud::PAGE_EDIT == $pageName){
        $imageField->setRequired(false);
    };

    yield $imageField;
    }
    
}

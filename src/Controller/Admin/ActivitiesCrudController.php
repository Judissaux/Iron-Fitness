<?php

namespace App\Controller\Admin;

use App\Entity\Activities;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ActivitiesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Activities::class;
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
        {
            return $crud

            ->setEntityLabelInSingular('un cours')
            ->setEntityLabelInPlural('Cours collectifs')
            ->showEntityActionsInlined()
            ->renderContentMaximized();
        }

    
    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
       $uploadsDir = $this->getParameter('uploads_directory');

        yield TextField::new('title','Titre');
        yield SlugField::new('slug','Slug')
        ->setTargetFieldName('title')
        ->hideOnIndex();
        yield TextareaField::new('description','Description');
        $imageField = ImageField::new('illustration', 'Images')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $imageField->setRequired(false);
        };

        yield $imageField;

        yield IntegerField::new('calories','Calories');
        yield IntegerField::new('time','Temps');
       
    }
    
}

<?php

namespace App\Controller\Admin;

use App\Entity\General;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class GeneralCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return General::class;
    }


    public function configureActions(Actions $actions): Actions
    {   
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
            return $action->addCssClass('btn btn-primary btn-lg');
            })
            ->remove(Crud::PAGE_INDEX, Action::NEW)
            ->remove(Crud::PAGE_INDEX, Action::DELETE)
            ->remove(Crud::PAGE_EDIT,Action::SAVE_AND_CONTINUE);
            
            
    }
    
    public function configureCrud(Crud $crud): Crud
    {
        return $crud
        ->setSearchFields(null)
        ->showEntityActionsInlined()
        ->renderContentMaximized()
        ->setPaginatorRangeSize(0);
        
        
    }

    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadsDir = $this->getParameter('uploads_directory');

        yield TextField::new('nameSite','Nom du site'); 
               
        $logoField = ImageField::new('illustration', 'Logo')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $logoField->setRequired(false);
        };

        yield $logoField;
               
        $planningField = ImageField::new('planning', 'Planning')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]');

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $planningField->setRequired(false);
        };

        yield $planningField;

        yield TextField::new('scrollingMessage','Message défilant'); 
        
        yield MoneyField::new('price','Tarif')->setCurrency('EUR'); 
        yield MoneyField::new('entrance','Frais d\'inscription')->setCurrency('EUR'); 
        yield TelephoneField::new('PhoneNumber','Téléphone');
        yield TextField::new('linkFacebook','Lien Facebook');
        yield TextField::new('linkInstagram','Lien Instagram');
          
    }
    
}

<?php

namespace App\Controller\Admin;

use App\Entity\General;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;

class GeneralCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return General::class;
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

        yield TextField::new('nameSite','Nom du site'); 
               
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
          
    }
    
}

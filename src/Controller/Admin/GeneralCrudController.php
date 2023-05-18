<?php

namespace App\Controller\Admin;

use App\Entity\General;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use App\Validator\EasyAdminIllustrationConstraint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Form\Type\FileUploadType;
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
        ->setPaginatorRangeSize(0)
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');       
        
        
    }

    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadsDir = $this->getParameter('uploads_directory');

        yield TextField::new('nameSite','Nom du site'); 
               
        $logoField = ImageField::new('illustration', 'Logo')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ->setFormTypeOption(
            'constraints',
            [
                new EasyAdminIllustrationConstraint([
                    'mimeTypes' => [ // We want to let upload only jpeg or png
                        'image/jpeg',
                        'image/png',
                    ],
                ])
                ]);

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $logoField->setRequired(false);
        };

        yield $logoField;
               
        $planningField = ImageField::new('planning', 'Planning')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ->setFormTypeOption(
            'constraints',
            [
                new EasyAdminIllustrationConstraint([
                    'mimeTypes' => [ // We want to let upload only jpeg or png
                        'image/jpeg',
                        'image/png',
                    ],
                ])
                ]);

        //Permet d'enregistrer les modifications sans devoir remettre une image
        if(Crud::PAGE_EDIT == $pageName){
            $planningField->setRequired(false);
        };

        yield $planningField;

        yield TextField::new('scrollingMessage','Message défilant')->hideOnIndex(); 
        
        yield MoneyField::new('price','Tarif')->setCurrency('EUR'); 

        yield MoneyField::new('entrance','Frais d\'inscription')->setCurrency('EUR'); 

        yield TelephoneField::new('PhoneNumber','Téléphone');

        yield TextField::new('linkFacebook','Lien Facebook')->hideOnIndex();

        yield TextField::new('linkInstagram','Lien Instagram')->hideOnIndex();

        yield TextEditorField::new('mentionLegale','Mentions légales')->setFormType(CKEditorType::class)->hideOnIndex();


        yield ImageField::new('cgu', 'Condition Générale d\'Utilisation')
        ->setFormType(FileUploadType::class)
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setColumns(6)
        ->hideOnIndex()
        ->setFormTypeOption(
            'constraints',
            [
                new EasyAdminIllustrationConstraint([
                    'mimeTypes' => [ // We want to let upload only jpeg or png
                        'application/pdf',                            
                    ],
                ])
            ]);
        
            yield ImageField::new('cgv', 'Condition Générale de Vente')
            ->setFormType(FileUploadType::class)
            ->setBasePath($uploadsDir)
            ->setUploadDir($mediaDir)
            ->setColumns(6)
            ->hideOnIndex()
            ->setFormTypeOption(
                'constraints',
                [
                    new EasyAdminIllustrationConstraint([
                        'mimeTypes' => [ // We want to let upload only jpeg or png
                            'application/pdf',                            
                        ],
                    ])
                ]);
    
               
        yield TextEditorField::new('emailClient','Email du client')->setFormType(CKEditorType::class);

        yield TextEditorField::new('emailClientRefus','Email du client lors d\'un refus/erreur')->setFormType(CKEditorType::class);

          
    }
    
}

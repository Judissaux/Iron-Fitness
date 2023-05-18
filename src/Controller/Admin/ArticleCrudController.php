<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Validator\EasyAdminIllustrationConstraint;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ArticleCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Article::class;
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
        ->renderContentMaximized()
        ->setPaginatorPageSize(10)
        ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
        
    }


    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadsDir = $this->getParameter('uploads_directory');
    
        yield TextField::new('title','Titre');  

        yield SlugField::new('slug','Slug')
        ->setTargetFieldName('title')
        ->hideOnIndex(); 
          
    
        yield TextEditorField::new('description','Description')->setFormType(CKEditorType::class);
        
        $imageField = ImageField::new('illustration', 'Images')
        ->setBasePath($uploadsDir)
        ->setUploadDir($mediaDir)
        ->setUploadedFileNamePattern('[slug]-[uuid].[extension]')
        ->setHelp('Seulement .png ou .jpg et max image de taille 1Mo' )
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
            $imageField->setRequired(false);
        };

        yield $imageField;

        yield  DateTimeField::new('createdAt','Créé le')->hideOnForm();

        yield  DateTimeField::new('updatedAt','Mis à jour le')->hideOnForm();        
    }

}


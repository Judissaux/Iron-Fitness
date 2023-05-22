<?php

namespace App\Controller\Admin;

use App\Entity\Exercises;

use App\Validator\UploadTypeConstraint;
use FOS\CKEditorBundle\Form\Type\CKEditorType;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExercisesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Exercises::class;
    }
    
    

    public function configureCrud(Crud $crud): Crud
        {
            return $crud

            ->setEntityLabelInSingular('un exercice')
            ->showEntityActionsInlined()
            ->renderContentMaximized()
            ->setPaginatorPageSize(10)
            ->addFormTheme('@FOSCKEditor/Form/ckeditor_widget.html.twig');
           
        }
    
    public function configureFields(string $pageName): iterable
    {
        $mediaDir = $this->getParameter('medias_directory');
        $uploadsDir = $this->getParameter('uploads_directory');

        yield TextField::new('name','Nom');   

        yield TextEditorField::new('description','Description')->setFormType(CKEditorType::class);
        
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

        yield TextField::new('video','Lien vidéo')
        ->setHelp('Récupérer le code de fin d\'URL juste aprés le "v=" : Exemple "NPbVrgRBtBY"');
       
    }    
}

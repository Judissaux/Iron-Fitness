<?php

namespace App\Controller\Admin;



use App\Entity\ExerciseSet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ExerciseSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExerciseSet::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud

        
        ->showEntityActionsInlined()
        ->renderContentMaximized()
        ->setFormOptions([
            'validation_groups' => ['Default', 'my_validation_group']
        ]);
        
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('exercise');
        yield IntegerField::new('repetition','Nombre de répétition: ');
        yield IntegerField::new('series','Nombre de série: ');
        yield IntegerField::new('rest','Temps de repos: ');
        yield IntegerField::new('duration','Durée de l\'exercice: ');           
    }

}
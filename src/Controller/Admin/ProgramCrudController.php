<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::NEW);
    }

    public function configureCrud(Crud $crud): Crud
        {
            return $crud

            ->setEntityLabelInSingular('un programme')
            ->setEntityLabelInPlural('Programmes')
            ->showEntityActionsInlined()
            ->renderContentMaximized();
            
            
        }

    
    public function configureFields(string $pageName): iterable
    {
       yield TextField::new('name', 'Nom du programme');
       yield CollectionField::new('exercises','Exercices')->useEntryCrudForm(ExerciseSetCrudController::class);
    }
    
}

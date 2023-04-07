<?php

namespace App\Controller\Admin;

use App\Entity\Program;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;

class ProgramCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Program::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name','Nom');
        yield CollectionField::new('exercise','Exercice')->useEntryCrudForm(ExerciseSetCrudController::class);;
    }
    
}

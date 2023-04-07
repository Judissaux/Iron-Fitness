<?php

namespace App\Controller\Admin;

use App\Entity\ExerciseSet;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

class ExerciseSetCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ExerciseSet::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('exercise','Exercice');
        yield IntegerField::new('repetition','rep');
        yield IntegerField::new('series','ser');
        yield IntegerField::new('rest','repos');
    }
    
}

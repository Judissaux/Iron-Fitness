<?php

namespace App\Controller\Admin;



use App\Entity\ExerciseSet;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Component\Routing\Annotation\Route;



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
        ->renderContentMaximized();       
    }

    public function configureFields(string $pageName): iterable
    {
        yield AssociationField::new('exercise',"Exercice")->setColumns(12)->addCssClass('text-center'); 

        yield IntegerField::new('repetition','Nombre de répétition: ')        
        ->setColumns(12)
        ->addCssClass('text-center');  

        yield IntegerField::new('series','Nombre de série: ')
        ->setColumns(12)
        ->addCssClass('text-center');

        yield IntegerField::new('rest','Temps de repos: ')        
        ->setColumns(12)
        ->setHelp('Temps en secondes')
        ->addCssClass('text-center');

        yield IntegerField::new('duration','Distance à parcourir')
        ->setColumns(12)
        ->setHelp('Distance en métres')
        ->addCssClass('text-center');           
    }

}
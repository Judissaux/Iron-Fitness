<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Program;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use App\Controller\Admin\ExerciseSetCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
            ->setPaginatorPageSize(15)
            ->renderContentMaximized();
            
        }

    
    public function configureFields(string $pageName): iterable
    {
       yield TextField::new('name', 'Nom du programme');
       yield ChoiceField::new('day','Jour de réalisation du programme')             
       ->setChoices([
           'Lundi' => 'Lundi',
           'Mardi' => 'Mardi',
           'Mercredi' => 'Mercredi',
           'Jeudi' => 'Jeudi',
           'Vendredi' => 'Vendredi',
           'Samedi' => 'Samedi',
       ]);
       yield  DateTimeField::new('createdAt','Créé le')->hideOnForm();
       yield TextField::new('creator', 'Créateur du programme')->hideOnForm();      
       yield CollectionField::new('exercises','Exercices')->useEntryCrudForm(ExerciseSetCrudController::class);
       yield  DateTimeField::new('updatedAt','Mis à jour le')->hideOnForm(); 
       yield TextField::new('modifiedBy', 'Modifié par ')->hideOnForm(); 
    }
    
    // Permet de mettre en place des informations avant la mise en BDD lors de la création d'une entité
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
        {   
            /** @var User $user */ 
            $user  = $this->getUser();
           
            $program = $entityInstance;
                                               
            $creator = $user->getFirstname();

            $program->setCreator($creator);          
                    
            parent::persistEntity($entityManager,$entityInstance);
    
        }  

        // Permet de mettre en place des informations avant la mise en BDD lors de la modification d'une entité
        public function updateEntity(EntityManagerInterface $entityManager, $entityInstance): void
        {
            /** @var User $user */
            $user = $this->getUser();

            $program = $entityInstance;
            $modifier = $user->getFirstname();

            $program->setModifiedBy($modifier);

            parent::updateEntity($entityManager, $entityInstance);
        }
    
}

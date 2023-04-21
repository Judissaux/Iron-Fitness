<?php 

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\RedirectResponse;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
    
    class UserCrudController extends AbstractCrudController
    {   
    
        public function __construct(
            private EntityRepository $entityRepo,
            private UserPasswordHasherInterface $passwordHasher){        
        }
    
        public static function getEntityFqcn(): string
        {
            return User::class;
        }
        
        public function configureActions(Actions $actions): Actions
        {
            return $actions
                ->remove(Crud::PAGE_INDEX, Action::NEW);
        }
        public function configureCrud(Crud $crud): Crud
        {
            return $crud

            ->setEntityLabelInSingular('adhérent')
            ->setEntityLabelInPlural('Adhérents')
            ->showEntityActionsInlined()
            ->renderContentMaximized();
        }
       
        public function configureFields(string $pageName): iterable
        {
           yield TextField::new('lastname','Nom');

           yield TextField::new('firstname','Prénom');
           
           yield ChoiceField::new('roles')
            ->allowMultipleChoices()
            ->renderAsBadges([
                'ROLE_ADMIN' => 'success',
                'ROLE_AUTHOR' => 'warning'
            ])
            ->setChoices([
                'Administrateur' => 'ROLE_ADMIN',
                'Coach' => 'ROLE_COACH',
            ]);  

           yield EmailField::new('email','E-mail');

           yield TextField::new('password','Mot de passe')  
                ->onlyWhenCreating()
                ->setRequired( true );

           yield DateField::new('birthdayDate','Date de naissance');

           yield IntegerField::new('age','Age')->hideOnForm();  
                         
           yield TelephoneField::new('PhoneNumber','Téléphone');

        }
    
        /**
         * Fonction qui permet de hasher le mdp et d'avoir l'age  avant l'enregistrement en BDD
         */
        public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
        {
            $user = $entityInstance;
    
            $plainPassword = $user->getPassword();
    
            $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
            
            $user->setPassword($hashedPassword);

           
            $dateNaissance = $user->getbirthdayDate();
            $now = new \DateTime();
            $interval = $now->diff($dateNaissance);
            $age = $interval->y;
            $user->setAge($age);
    
            parent::persistEntity($entityManager,$entityInstance);
    
        }  
        
       



        
    }


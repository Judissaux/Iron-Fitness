<?php

namespace App\Controller\Admin;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
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

    
    public function configureFields(string $pageName): iterable
    {
       yield TextField::new('nom','Nom');
       yield TextField::new('prenom','Prénom');
       yield TextField::new('email','E-mail');
       yield TextField::new('password','Mot de passe')
            ->setFormType(PasswordType::class)
            ->onlyOnForms();
    }

    /**
     * Fonction qui permet de hasher le mdp avant l'enregistrement en BDD
     */
    public function persistEntity(EntityManagerInterface $entityManager, $entityInstance): void
    {
        $user = $entityInstance;

        $plainPassword = $user->getPassword();

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        
        $user->setPassword($hashedPassword);

        parent::persistEntity($entityManager,$entityInstance);

    }
    
}

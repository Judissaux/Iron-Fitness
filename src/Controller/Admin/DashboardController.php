<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Entity\Coach;
use App\Entity\Article;
use App\Entity\Program;
use App\Entity\Exercises;
use App\Entity\Activities;
use Symfony\Component\HttpFoundation\Response;
use App\Controller\Admin\ProgramCrudController;
use App\Entity\General;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {   
        if($this->isGranted('ROLE_ADMIN')){
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
        }

        if($this->isGranted('ROLE_COACH')){
            $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($adminUrlGenerator->setController(ProgramCrudController::class)->setAction(Crud::PAGE_NEW)->generateUrl());
            }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord IronFitness');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retourner sur le site', 'fa fa-undo','app_home');

        if($this->isGranted('ROLE_ADMIN')){

            yield MenuItem::linkToCrud('Informations du site', 'fas fa-gear',General::class);               

           yield  MenuItem::linkToCrud('Comptes adhérents', 'fas fa-user-friends',User::class);

            yield MenuItem::linkToCrud('Coachs', 'fas fa-user',Coach::class);
               
            yield MenuItem::linkToCrud('Cours-collectifs', 'fas fa-clipboard',Activities::class);

            yield MenuItem::linkToCrud('Articles', 'fas fa-newspaper',Article::class);
               
           
        }
        if($this->isGranted('ROLE_COACH')){

            yield MenuItem::linkToCrud('Exercices', 'fas fa-person-walking',Exercises::class);               
            
            yield  MenuItem::linkToCrud('Programmes', 'fas fa-person-chalkboard',Program::class);
               
        }
               
    }
}

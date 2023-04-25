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
            yield MenuItem::subMenu('Comptes', 'fas fa-user')->setSubItems([
                MenuItem::linkToCrud('Tous les comptes', 'fas fa-user-friends',User::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',User::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);

            yield MenuItem::subMenu('Coachs', 'fas fa-people-robbery')->setSubItems([
                MenuItem::linkToCrud('Tous les coachs', 'fas fa-user',Coach::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Coach::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);

            yield MenuItem::subMenu('Cours collectifs', 'fas fa-person-walking')->setSubItems([
                MenuItem::linkToCrud('Tous les cours', 'fas fa-clipboard',Activities::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Activities::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);

            yield MenuItem::subMenu('Articles', 'fas fa-newspaper')->setSubItems([
                MenuItem::linkToCrud('Tous les articles', 'fas fa-rectangle-list',Article::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Article::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);
        }
        if($this->isGranted('ROLE_COACH')){
            yield MenuItem::subMenu('Exercices', 'fas fa-person-running')->setSubItems([
                MenuItem::linkToCrud('Tous les exercices', 'fas fa-rectangle-list',Exercises::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Exercises::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);

            yield MenuItem::subMenu('Programmes', 'fas fa-id-badge')->setSubItems([
                MenuItem::linkToCrud('Tous les programmes', 'fas fa-rectangle-list',Program::class)->setQueryParameter('submenuIndex', 0),
                MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Program::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
            ]);
        }
               
    }
}

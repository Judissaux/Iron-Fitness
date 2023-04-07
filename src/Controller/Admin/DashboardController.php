<?php

namespace App\Controller\Admin;

use App\Entity\Activities;
use App\Entity\Article;
use App\Entity\Adherants;
use App\Entity\Coach;
use App\Entity\Exercise;
use App\Entity\Program;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Response;
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
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(UserCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Tableau de bord IronFitness');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Retourner sur le site', 'fa fa-undo','app_home');

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

        yield MenuItem::subMenu('Exercices', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les exercices', 'fas fa-rectangle-list',Exercise::class)->setQueryParameter('submenuIndex', 0),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Exercise::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
        ]);

        yield MenuItem::subMenu('Programmes', 'fas fa-newspaper')->setSubItems([
            MenuItem::linkToCrud('Tous les programmes', 'fas fa-rectangle-list',Program::class)->setQueryParameter('submenuIndex', 0),
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus',Program::class)->setQueryParameter('submenuIndex', 1)->setAction(Crud::PAGE_NEW),
        ]);
        
        
    }
}

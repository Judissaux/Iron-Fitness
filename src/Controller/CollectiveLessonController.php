<?php

namespace App\Controller;

use App\Repository\ActivitiesRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectiveLessonController extends AbstractController
{
    #[Route('/cours-collectifs', name: 'app_collective_lesson')]
    public function index(ActivitiesRepository $activitiesRepo, Request $request, PaginatorInterface $paginator): Response
    {   

        $donnees =  $activitiesRepo->findAll();

        $activities = $paginator->paginate(
            $donnees,
            $request->query->getInt('page', 1),
            6
        );
        return $this->render('autresPages/collectiveLesson.html.twig',compact('activities'));
    }
}

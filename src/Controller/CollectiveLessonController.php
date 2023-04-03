<?php

namespace App\Controller;

use App\Repository\ActivitiesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CollectiveLessonController extends AbstractController
{
    #[Route('/cours-collectifs', name: 'app_collective_lesson')]
    public function index(ActivitiesRepository $activitiesRepo): Response
    {
        return $this->render('autresPages/collectiveLesson.html.twig', [
            'activities' => $activitiesRepo->findAll()
        ]);
    }
}

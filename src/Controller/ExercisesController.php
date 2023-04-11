<?php

namespace App\Controller;

use App\Repository\ExercisesRepository;
use App\Service\ProgramService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ExercisesController extends AbstractController
{
    #[Route('/admin/exercices', name: 'app_exercices')]
    public function index(ExercisesRepository $exercisesRepo): Response
    {
        return $this->render('admin/exercices/index.html.twig', [
            'exercices' => $exercisesRepo->findAll()
        ]);
    }

    #[Route('/admin/programme/{id}', name: 'app_program')]
    public function program ($id,ProgramService $programService): Response
    {
        $programService->add($id);
        $exercises = $programService->getFullProgram();
        return $this->render('admin/programme/index.html.twig', compact('exercises'));
    }
}

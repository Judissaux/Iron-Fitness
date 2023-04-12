<?php

namespace App\Controller;

use App\Entity\ExerciceSet;
use App\Form\ExerciceSetType;
use App\Service\ProgramService;
use App\Repository\ExercisesRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ExercisesController extends AbstractController
{
    #[Route('/admin/exercices', name: 'app_exercices')]
    public function index(Request $request, ExercisesRepository $exercisesRepo): Response
    {
        $programSet = new  ExerciceSet();

        $form = $this->createForm(ExerciceSetType::class, $programSet);
        $form->handleRequest($request);
        if($form->isSubmitted()){
        dd($form->getData());
        }
        return $this->render('admin/exercices/index.html.twig', [
            'exercices' => $exercisesRepo->findAll(),
            'exoForm' => $form->createView()
        ]);
    }

    #[Route('/admin/programme/{id}', name: 'app_program')]
    public function program ($id,ProgramService $programService): Response
    {
        $programService->add($id);

        $exercises = $programService->getFullProgram();

        return $this->render('admin/programme/index.html.twig', [
            'exercises' => $exercises,
            
        ]);
    }
}

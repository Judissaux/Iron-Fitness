<?php

namespace App\Controller;

use App\Repository\ExerciseRepository;
use App\Repository\ExercisesRepository;
use App\Repository\ProgramRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CoachingController extends AbstractController
{
    #[Route('/coaching', name: 'app_coaching')]
    public function index(ProgramRepository $programRepo, ExercisesRepository $exercisesRepo): Response
    {         
        $programmes = $programRepo->findAll();
        
        $programme = [];
        foreach($programmes as $name){
            $programme  [] = [
                'nameProgram' => $name->getName(),
                'exercices' => $name->getExercises()->getValues()
            ];
        }
        
        $exo = [];
        foreach($programme as $exercice){
            foreach($exercice['exercices'] as $exos){
                $exo += $exercisesRepo->findAll($exos->getExercise()->getId());
            }
        }        

        return $this->render('autresPages/coaching.html.twig',[
            'program' => $programme,
            
        ]);
    }
}

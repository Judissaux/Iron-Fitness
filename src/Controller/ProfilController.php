<?php

namespace App\Controller;

use App\Repository\ProgramRepository;
use App\Repository\ExercisesRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(ProgramRepository $programRepo, ExercisesRepository $exercisesRepo): Response
    {         
        $programmes = $programRepo->findAll();
        
        $programme = [];
        foreach($programmes as $name){
            $programme  [] = [
                'name' => $name->getName(),
                'exercices' => $name->getExercises()->getValues()
            ];
        }
        
        $exo = [];
        foreach($programme as $exercice){
            foreach($exercice['exercices'] as $exos){
                $exo += $exercisesRepo->findAll($exos->getExercise()->getId());
            }
        }        

        return $this->render('profil/index.html.twig',[
            'programmes' => $programme,
            
        ]);
    }
}

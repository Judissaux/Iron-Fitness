<?php

namespace App\Service;

use App\Repository\ExercisesRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class ProgramService
{
    public function __construct(private RequestStack $request, protected ExercisesRepository $exercisesRepo){}

    public function add($id){

        $session =  $this->request->getSession();

        $program = $session->get('program', []);

        $program[$id] = $id;

        $session->set('program', $program);       
       
    }

    public function getFullProgram(){
        $session =  $this->request->getSession();

        $program = $session->get('program', []);

        $programFull = [] ;

        foreach($program as $id){
            $programFull [] = [
                'exercice' => $this->exercisesRepo->find($id)
            ];
        }

        return $programFull;
    }

}
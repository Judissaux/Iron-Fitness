<?php

namespace App\Controller;

use App\Form\FreeSessionType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


class HomeController extends AbstractController
{   
    
    #[Route('/', name: 'app_home')]
    public function index(): Response
    {   
        
        return $this->render('home/index.html.twig');
    }   
    
    #[Route('/traitement-formulaire-ajax', name: 'app_test')]
    public function addNavBar(Request $request){

        $form = $this->createForm(FreeSessionType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
           $this->addFlash('success', 'Votre séance est enregistré, nous vous attendons avec impatience.');
        }

        if ($request->isXmlHttpRequest() && !$form->isValid()) {
            $this->addFlash('error', 'Une erreur est survenue lors de la soumission du formulaire.');
        }
       
        return $this->render('_partials/_navbar.html.twig', [
            'form' => $form->createView()
        ]);

    }
    
    
}

<?php

namespace App\Controller;

use App\Form\FreeSessionType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

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

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('success','Votre séance est enregistré, nous vous attendons avec impatience pour vous faire découvrir la salle.');
        }
        
        if ($form->isSubmitted() && !$form->isValid()) {
            // Récupération des erreurs et envoi sous forme de chaîne de caractères JSON
                return new JsonResponse($this->getErrorsMessages($form), 400);
            }      
        
                
        return $this->render('_partials/_navbar.html.twig', [
            'form' => $form->createView()
        ]);

    }
    

    //Fonction pour récupérer les erreurs
    private function getErrorsMessages(FormInterface $form) : array
    {
        $errors = [];

        foreach($form->getErrors() as $error)
        {
            $errors[] = $error->getMessage();
        }
        foreach($form->all() as $child)
        {
            if(!$child->isValid()){
                $errors[$child->getName()] = $this->getErrorsMessages($child);
            }
        }

        return $errors;
    }
}

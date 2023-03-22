<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\RegisterFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class RegisterController extends AbstractController
{   
    public function __construct(private EntityManagerInterface $em){}

    #[Route('/inscription' , name: 'app_register')]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($user);
            // $this->em->flush();
             $this->addFlash('success', 'Votre enregistrement a été pris en compte nous vous attendons à la salle pour finaliser votre inscription');
            return $this->redirectToRoute('app_home');
           
        }

        return $this->render('autresPages/register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}

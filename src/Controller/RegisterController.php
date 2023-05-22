<?php

namespace App\Controller;

use App\Entity\TemporaryUser;
use App\Form\RegisterFormType;
use App\Service\MailerService;
use App\Repository\GeneralRepository;
use App\Repository\TemporaryUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{   
    public function __construct(private MailerService $mailer,private EntityManagerInterface $em){}

    #[Route('/inscription' , name: 'app_register')]
    public function index(Request $request,GeneralRepository $generalRepo,TemporaryUserRepository $temporaryUserRepository): Response
    {
       
        $user = new TemporaryUser();
        $form = $this->createForm(RegisterFormType::class,$user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $temporaryUser = $temporaryUserRepository->findOneBy(["email" => $user->getEmail()]);
               
                if(!$temporaryUser){
                $user = $form->getData();
                $this->em->persist($user);
                $this->em->flush(); 
                return $this->redirectToRoute('app_stripe');
                }else{
                    $email = $temporaryUser->getEmail();
                    return $this->redirectToRoute('app_stripe_email', ['email' => $email]);
                }              
                
           
            }

        return $this->render('autresPages/register.html.twig', [
            'registerForm' => $form->createView(),
            'general' => $generalRepo->findAll()
        ]);
    }
}

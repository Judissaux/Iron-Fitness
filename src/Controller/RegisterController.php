<?php

namespace App\Controller;

use App\Entity\User;

use App\Form\RegisterFormType;
use App\Service\MailerService;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{   
    public function __construct(private EntityManagerInterface $em, private MailerService $mailer){}

    #[Route('/inscription' , name: 'app_register')]
    public function index(Request $request): Response
    {
        $user = new User();
        $form = $this->createForm(RegisterFormType::class,$user);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
                $nom = $contact->get('nom')->getData();
                $prenom =  $contact->get('prenom')->getData();
                $sexe = $contact->get('sexe')->getData();                           
                $dateNaissance = $contact->get('dateNaissance')->getData();
                $telephone = $contact->get('numTelephone')->getData();
                
                
                    $this->mailer->sendEmail(
                        $from = $contact->get('email')->getData(),
                        $to = 'caswalcha@gmail.com',
                        $subject = 'Nouvelle Inscription de ' . $nom .' '. $prenom,
                        $adresseTemplate = 'emails/contactInscription.html.twig',
                        $context = [
                            'mail' => $from,
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'sexe' => $sexe,
                            'dateNaissance' =>$dateNaissance, 
                            'telephone' => $telephone                   
                        ]
                    );

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

<?php

namespace App\Controller;


use App\Form\RegisterFormType;
use App\Service\MailerService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RegisterController extends AbstractController
{   
    public function __construct(private MailerService $mailer){}

    #[Route('/inscription' , name: 'app_register')]
    public function index(Request $request): Response
    {
        $form = $this->createForm(RegisterFormType::class);

        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            
                $nom = $contact->get('nom')->getData();
                $prenom =  $contact->get('prenom')->getData();
                $sexe = $contact->get('sexe')->getData(); 
                // Ici on réalise une condition pour afficher 'monsieur' ou 'madame' en fonction du sexe sélectionné
                ($sexe== 'M') ? $sexe='Monsieur' : $sexe='Madame';                     
                // Ici on découpe le téléphone pour afficher un '-' tous les 2 caractéres                 
                $telephone = wordwrap($contact->get('numTelephone')->getData(),2,'-',true);               
                
                    $this->mailer->sendEmail(
                        $from = $contact->get('email')->getData(),
                        $to = 'justin.dissaux@laposte.net',
                        'Nouvelle Inscription de ' . $nom .' '. $prenom,
                        'emails/contactInscription.html.twig',
                        [
                            'mail' => $from,
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'sexe' => $sexe,
                            'telephone' => $telephone,
                        ]
                    );

                    $this->addFlash('success', 'Votre enregistrement a été pris en compte nous vous attendons à la salle pour finaliser votre inscription');
                    return $this->redirectToRoute('app_home');
           
            }

        return $this->render('autresPages/register.html.twig', [
            'registerForm' => $form->createView()
        ]);
    }
}

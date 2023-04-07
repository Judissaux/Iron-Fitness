<?php

namespace App\Controller;

use App\Form\FreeSessionType;
use App\Repository\CoachRepository;
use App\Service\MailerService;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{   
    public function __construct(private MailerService $mailer){}

    #[Route('/', name: 'app_home')]
    public function index(CoachRepository $coachRepo): Response
    {           
        return $this->render('home/index.html.twig', [
            'coachs' => $coachRepo->findAll()
        ]);
    }   
    
    #[Route('/traitement-formulaire-ajax', name: 'app_test')]
    public function addNavBar(Request $request){

        $form = $this->createForm(FreeSessionType::class);
        $contact = $form->handleRequest($request);   

        //Ici le formulaire est soumis et valide
        if ($form->isSubmitted() && $form->isValid()) {
            $nom = $contact->get('nom')->getData();
                $prenom =  $contact->get('prenom')->getData();
                $sexe = $contact->get('sexe')->getData(); 
                // Ici on réalise une condition pour afficher 'monsieur' ou 'madame' en fonction du sexe sélectionné
                ($sexe== 'M') ? $sexe='Monsieur' : $sexe='Madame';                     
                $datePresence = $contact->get('datePresence')->getData();
                // Ici on découpe le téléphone pour afficher un '-' tous les 2 caractéres                 
                $telephone = wordwrap($contact->get('numTelephone')->getData(),2,'-',true);               
                
                    $this->mailer->sendEmail(
                        $from = $contact->get('email')->getData(),
                        $to = 'caswalcha@gmail.com',
                        $subject = 'Demande séance gratuite de ' . $nom .' '. $prenom,
                        $adresseTemplate = 'emails/seancegratuite.html.twig',
                        $context = [
                            'mail' => $from,
                            'nom' => $nom,
                            'prenom' => $prenom,
                            'sexe' => $sexe,
                            'datePresence' =>$datePresence, 
                            'telephone' => $telephone,
                            'date' => new \DateTime()                   
                        ]
                    );
            $this->addFlash('success','Votre séance est enregistré, nous vous attendons avec impatience pour vous faire découvrir la salle.');
        }
        
        // Ici une erreur liée à une contrainte est détectée, les erreurs sont envoyées en Json directement dans le formulaire
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
        
        // On parcourt le formulaire pour trouver des erreurs
        foreach($form->getErrors() as $error)
        {
            $errors[] = $error->getMessage();
            
        }

        //On parcourt tous le formulaire pour trouvez les éléments 
        foreach($form->all() as $child)        
        {
            //Si un élément présente une erreurs , on entre dans la condition
            if(!$child->isValid()){
                //On récupére le nom de l'élement et de manières récursive on récupére son message d'erreur en faisant appelle à la fonction 
                $errors[$child->getName()] = $this->getErrorsMessages($child);
                
            }            
        }        
        return $errors;
    }
}

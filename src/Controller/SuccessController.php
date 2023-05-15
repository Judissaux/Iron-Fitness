<?php

namespace App\Controller;

use App\Repository\GeneralRepository;

use App\Service\MailerService;
use App\Repository\TemporaryUserRepository;
use DateTime;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{
    #[Route('/enregistrement/merci/{stripeSessionId}', name: 'app_success')]
    public function index(
        TemporaryUserRepository $temporaryUserRepo,        
        MailerService $mailer,
        GeneralRepository $generalRepo,
        $stripeSessionId
        )
    {   
        $user = $temporaryUserRepo->findOneByStripeSessionId($stripeSessionId);

        $infos = $generalRepo->findAll();
        $customMail = $infos[0]->getEmailClient();
        $now = new DateTime();
        $dateNaissance = $user->getBirthdayDate() ;
        $age = $now->diff($dateNaissance, true)->y;
        if(!$user ){
            $this->addFlash('warning', 'Erreur lors de l\'inscription');
            return $this->redirectToRoute('app_home');
        }

        // Mail pour l'administrateur
        $mailer->sendEmail(

                        'Nouvelle Inscription de ' .ucfirst(strtolower($user->getLastname())) .' '. ucfirst(strtolower($user->getFirstname())),
                        'emails/contactInscription.html.twig',
                        [
                            'mail' => $user->getEmail(),
                            'nom' => strtolower($user->getLastname()),
                            'prenom' => strtolower($user->getFirstname()),
                            'sexe' => $user->getSexe(),
                            'telephone' => $user->getPhoneNumber(),
                            'age' => $age
                        ],                        
                );
            // Mail pour l\'adhérent
            $mailer->sendEmail(

                'Enregistrement de ' .ucfirst(strtolower($user->getLastname())) .' '. ucfirst(strtolower($user->getFirstname())),
                'emails/success.html.twig',
                [
                    'nom' => strtolower($user->getLastname()),
                    'prenom' => strtolower($user->getFirstname()),
                    'sexe' => $user->getSexe(),
                    'content' => $customMail
                ],
                to: $user->getEmail(),                        
            );
                    
            $temporaryUserRepo->deleteById($user->getId());
            $this->addFlash('success', 'Votre enregistrement a été pris en compte, vous allez recevoir un mail à présenter lors de votre première séance.');
            return $this->redirectToRoute('app_home');
    }

    public function customEmail(GeneralRepository $general)
    {
        

        return $this->render('emails/success.html.twig', compact('customMail'));
    }
}

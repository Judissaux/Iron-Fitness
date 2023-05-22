<?php

namespace App\Controller;

use DateTime;

use Stripe\Stripe;
use Stripe\Invoice;
use Stripe\PaymentIntent;
use Stripe\Checkout\Session;
use App\Service\MailerService;
use App\Repository\GeneralRepository;
use App\Repository\TemporaryUserRepository;
use Stripe\Charge;
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
        Stripe::setApiKey($this->getParameter('stripe_sk'));

        // Récupération de la session utilisateur
        $session = Session::retrieve(
            $stripeSessionId);
            
        // Récupération des informations de paiement
        $paymentIntent = PaymentIntent::retrieve($session->payment_intent);
        
        // Récupération facture client
        $test= Invoice::retrieve($paymentIntent->invoice);
        // Ici la facture en PDF
        $facture = $test->hosted_invoice_url;


        // Récupération des informations permettant de récupérer le reçu de commande
        // $receipt = Charge::retrieve($paymentIntent->latest_charge);       
        // // Récupération de l'url du recu
        // $recu = $receipt->receipt_url;    
               
        
        $infos = $generalRepo->findAll();
        $telephone = wordwrap($user->getPhoneNumber(), 2, "-", 1);
        $customMail = $infos[0]->getEmailClient();
        $now = new DateTime();
        $dateNaissance = $user->getBirthdayDate();
        $age = $now->diff($dateNaissance, true)->y;
        $stringDn = $dateNaissance = date_format($user->getBirthdayDate(),('d-m-Y'));
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
                            'telephone' => $telephone,
                            'age' => $age,
                            'dateNaissance' => $stringDn
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
                    'content' => $customMail,
                    'facture' => $facture
                ],
                to: $user->getEmail(),                        
            );
                    
            $temporaryUserRepo->deleteById($user->getId());
            $this->addFlash('success', 'Votre enregistrement a été pris en compte, vous allez recevoir un mail à présenter lors de votre première séance.');
            return $this->redirectToRoute('app_home');
    }

}

<?php

namespace App\Controller;

use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Repository\GeneralRepository;
use App\Repository\TemporaryUserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class StripeController extends AbstractController
{   
    /**
     * Controlleur pour création d'un nouvel adhérent qui n'a pas encore essayé de s'incrire
     *
     * @param EntityManagerInterface $entityManager
     * @param GeneralRepository $general
     * @param TemporaryUserRepository $temporaryUserRepo
     * @return void
     */
    #[Route('/commande/create_session', name: 'app_stripe')]
    public function index(
        EntityManagerInterface $entityManager,
        GeneralRepository $general,
        TemporaryUserRepository $temporaryUserRepo)
    {
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $infos = $general->findAll();
        $user = $temporaryUserRepo->findOneBy([], ['id' => 'DESC']);

        Stripe::setApiKey($this->getParameter('stripe_sk'));

        $price [] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $infos[0]->getPrice(),
                'product_data' => [
                    'name' => 'Abonnement 1 mois',
                ],
            ],

            'quantity' => 1,

            ];  

        $price [] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $infos[0]->getEntrance(),
                'product_data' => [
                    'name' => 'Frais d\'inscription',
                ],
            ],
            'quantity' => 1,
            ];  
        
        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'line_items' => [
                $price
                ],
                'mode' => 'payment',
                'invoice_creation' => ['enabled' => true],
                'success_url' => $YOUR_DOMAIN . '/enregistrement/merci/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/enregistrement/erreur/{CHECKOUT_SESSION_ID}',
            ]);   
            
         $user->setStripeSessionId($checkout_session->id); 
         $entityManager->flush();

         return $this->redirect($checkout_session->url);         
            
    }   
    
    /**
     *  Controlleur qui est le même qu'au dessus sauf qu'ici nous récupérons l'email d'une personne qui a déja tenté de s'inscrire auparavant
     */
    #[Route('/commande/create_session/{email}', name: 'app_stripe_email')]
    public function indexWithEmail(
        EntityManagerInterface $entityManager,
        GeneralRepository $general,
        TemporaryUserRepository $temporaryUserRepo,
        $email)
    {
        header('Content-Type: application/json');
        $YOUR_DOMAIN = 'http://127.0.0.1:8000';
        $infos = $general->findAll();
        $user = $temporaryUserRepo->findOneBy(['email' => $email]);

        Stripe::setApiKey($this->getParameter('stripe_sk'));

        $price [] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $infos[0]->getPrice(),
                'product_data' => [
                    'name' => 'Abonnement 1 mois',
                ],
            ],

            'quantity' => 1,

            ];  

        $price [] = [
            'price_data' => [
                'currency' => 'eur',
                'unit_amount' => $infos[0]->getEntrance(),
                'product_data' => [
                    'name' => 'Frais d\'inscription',
                ],
            ],
            'quantity' => 1,
            ];  
        
        $checkout_session = Session::create([
            'customer_email' => $user->getEmail(),
            'line_items' => [
                $price
                ],
                'mode' => 'payment',
                'success_url' => $YOUR_DOMAIN . '/enregistrement/merci/{CHECKOUT_SESSION_ID}',
                'cancel_url' => $YOUR_DOMAIN . '/enregistrement/erreur/{CHECKOUT_SESSION_ID}',
            ]);   
            
         $user->setStripeSessionId($checkout_session->id); 
         $entityManager->flush();

         return $this->redirect($checkout_session->url);         
            
    }    
}

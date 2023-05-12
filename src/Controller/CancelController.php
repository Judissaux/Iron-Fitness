<?php

namespace App\Controller;

use App\Service\MailerService;
use App\Repository\TemporaryUserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CancelController extends AbstractController
{
    #[Route('/enregistrement/erreur/{stripeSessionId}', name: 'app_cancel')]
    public function index(
        TemporaryUserRepository $temporaryUserRepo,        
        $stripeSessionId
        )
    {
        $user = $temporaryUserRepo->findOneByStripeSessionId($stripeSessionId);
       
        if( !$user ){
            $this->addFlash('warning', 'Erreur lors de l\'inscription');
            return  $this->redirectToRoute('app_home');
        }

        $infoUser = [
            'sexe' => $user->getSexe(),
            'nom' => $user->getLastname(),
            'prenom' => $user->getFirstname(),
        ];

        $temporaryUserRepo->deleteById($user->getId());

        return $this->render('autresPages/cancel.html.twig', compact('infoUser'));
        
    }
}

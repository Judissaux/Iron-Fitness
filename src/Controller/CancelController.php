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

        if(!$user ){
            $this->addFlash('warning', 'Erreur lors de l\'inscription');
            $this->redirectToRoute('app_home');
        }

        $temporaryUserRepo->deleteById($user->getId());
        $this->addFlash('warning', 'Votre enregistrement a échoué , retentez en ligne ou venez vous inscrire en centre directement.');
        return $this->redirectToRoute('app_home');
    }
}

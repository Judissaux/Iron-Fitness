<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use App\Repository\GeneralRepository;
use App\Repository\TemporaryUserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CancelController extends AbstractController
{
    #[Route('/enregistrement/erreur/{stripeSessionId}', name: 'app_cancel')]
    public function index(
        TemporaryUserRepository $temporaryUserRepo, 
        GeneralRepository $generalRepo,       
        $stripeSessionId
        )
    {
        $user = $temporaryUserRepo->findOneByStripeSessionId($stripeSessionId);
       
       
        $infos = $generalRepo->findAll();
        $customMail = $infos[0]->getEmailClientRefus();

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

        return $this->render('autresPages/cancel.html.twig', [
            'infoUser' => $infoUser,
            'content' => $customMail
        ]);
        
    }
}

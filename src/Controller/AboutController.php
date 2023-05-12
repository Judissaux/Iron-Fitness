<?php

namespace App\Controller;

use App\Repository\GeneralRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AboutController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_ml')]
    public function mentionLegale(GeneralRepository $general): Response
    {   

        $infos = $general->findAll();

        $mentionLegale = $infos[0]->getMentionLegale();
        return $this->render('aPropos/mentionsLegales.html.twig', compact('mentionLegale'));
    }

    

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        return $this->render('aPropos/cgu.html.twig');
    }

    #[Route('/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        return $this->render('aPropos/cgv.html.twig');
    }
}

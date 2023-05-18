<?php

namespace App\Controller;

use App\Repository\GeneralRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AboutController extends AbstractController
{
    public  function __construct(private GeneralRepository $general, private KernelInterface $kernelInterface)
    {
        
    }
    #[Route('/mentions-legales', name: 'app_ml')]
    public function mentionLegale(): Response
    {   

        $infos = $this->general->findAll();

        $mentionLegale = $infos[0]->getMentionLegale();
        return $this->render('aPropos/mentionsLegales.html.twig', compact('mentionLegale'));
    }

    

    #[Route('/cgu', name: 'app_cgu')]
    public function cgu(): Response
    {
        $infos = $this->general->findAll();
        $cgu = $infos[0]->getCgu();
        $projectRoot = $this->kernelInterface->getProjectDir();
        
        return new BinaryFileResponse( $projectRoot.'/public/uploads/'. $cgu );    
          
        
    }

    #[Route('/cgv', name: 'app_cgv')]
    public function cgv(): Response
    {
        $infos = $this->general->findAll();
        $cgu = $infos[0]->getCgv();
        $projectRoot = $this->kernelInterface->getProjectDir();
        
        return new BinaryFileResponse( $projectRoot.'/public/uploads/'. $cgu ); 
    }
}

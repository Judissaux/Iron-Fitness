<?php

namespace App\Service;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{   
    public function __construct(private MailerInterface $mailer){}
    
    public function sendEmail( 
       
        $subject,    
        $adresseTemplate,
        $context,
        $from = 'ici l\adresse fournie par l\hebergeur, utilisée pour l\inscription sur MailJet',
        $to = 'la même adresse que le from',
        ): void    
    {     
       // voir pour recuperer l'email dans un generalrepo , à voir
        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($adresseTemplate)
            ->context($context);           
       
        $this->mailer->send($email);
        
    }
}
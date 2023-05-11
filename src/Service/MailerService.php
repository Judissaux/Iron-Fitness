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
        $from = 'caswalcha@gmail.com',
        $to = 'caswalcha@gmail.com',
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
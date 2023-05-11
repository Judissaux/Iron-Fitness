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
        ): void    
    {     
       
        $email = (new TemplatedEmail())
            ->from('caswalcha@gmail.com')
            ->to('caswalcha@gmail.com')
            ->subject($subject)
            ->htmlTemplate($adresseTemplate)
            ->context($context);           
       
        $this->mailer->send($email);
        
    }
}
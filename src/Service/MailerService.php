<?php

namespace App\Service;


use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;

class MailerService
{   
    public function __construct(private MailerInterface $mailer){}

    public function sendEmail(    
    $from,
    $to,
    $subject,    
    $adresseTemplate,
    $context): void    
    {         

        $email = (new TemplatedEmail())
            ->from($from)
            ->to($to)
            ->subject($subject)
            ->htmlTemplate($adresseTemplate)
            ->context($context);           

        $this->mailer->send($email);
        
    }
}
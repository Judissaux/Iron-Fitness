<?php

namespace App\DataFixtures;

use App\Entity\User;
use DateTimeImmutable;
use App\Entity\General;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{

    public function __construct(private UserPasswordHasherInterface $hasher)
    {
    }
    
    public function load(ObjectManager $manager): void
    {
        $role = ['ROLE_ADMIN'];
        $general = new General();
        $general 
            ->setNameSite('IronFitness')
            ->setillustration('LeLogo')   
            ->setScrollingMessage('Le message défilant') 
            ->setPrice('2500')
            ->setEntrance('3000')
            ->setPhoneNumber('09-52-74-66-18')
            ->setMentionLegale('Les mentions légales')
            ->setCgu('Les cgu en pdf')
            ->setCgv('Les cgv en pdf')
            ->setEmailClient('Email reçu par le client en cas de réussite d\inscription')
            ->setPageErreurPaiement('Page d\'erreur de paiement');
        
        $manager->persist($general);   

        $user = new User();
        $user
            ->setEmail('admin@admin.fr') 
            ->setRoles($role)
            ->setFirstname('admin')
            ->setLastname('admin')
            ->setPhoneNumber('0606060606')
            ->setbirthdayDate(new DateTimeImmutable('now'))
            ->setAge('50');

        $password = $this->hasher->hashPassword($user, 'azerty');
        $user->setPassword($password);

        $manager->persist($user);

        $manager->flush();
    }
}

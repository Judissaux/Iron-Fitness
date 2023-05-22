<?php

namespace App\Controller;

use App\Form\ResetPasswordRequestType;
use App\Form\ResetPasswordType;
use App\Repository\UserRepository;
use App\Service\MailerService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    #[Route(path: '/connexion', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
         if ($this->getUser()) {
         return $this->redirectToRoute('app_home');
         }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    #[Route(path: '/logout', name: 'app_logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/oubli-mdp', name:'forgotten-password')]
    public function forgottenPassword(
    Request $request,
    UserRepository $userRepo,
    TokenGeneratorInterface $tokenGeneratorInterface,
    EntityManagerInterface $em,
    MailerService $mailer): Response
    {

        $form = $this->createForm(ResetPasswordRequestType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            // On va chercher l'utilisateur par son email
            $user = $userRepo->findOneByEmail($form->get('email')->getData());
            
            // On vérifie si on a un utilisateur
            if($user){
                // On génére un token de réinitialisation
                $token = $tokenGeneratorInterface->generateToken();
                 
                $user->setResetToken($token);                           
                $em->persist($user);
                $em->flush();

                // on génère le lien de réinitalisation du mot de passe
                $url = $this->generateUrl('reset_pass', ['token' => $token], UrlGeneratorInterface::ABSOLUTE_URL);

                // On crée les données du mail
                $mailer->sendEmail(

                    'Réinitialisation du mot de passe de  ' .ucfirst(strtolower($user->getLastname())) .' '. ucfirst(strtolower($user->getFirstname())),
                    'emails/réinitialisationMdp.html.twig',
                    [
                        'nom' => strtolower($user->getLastname()),
                        'prenom' => strtolower($user->getFirstname()),
                        'Urltoken' => $url,
                    ],

                    to: $form->get('email')->getData(),                        
                );

                $this->addFlash('success', 'E-mail de réinitialisation envoyé avec succés');
                return $this->redirectToRoute('app_login');
            }
        $this->addFlash('danger','Un problème est survenu.');
        return $this->redirectToRoute('app_login');
    }

        return $this->render('security/reset_password_request.html.twig', [
            'requestPassForm' => $form->createView()
        ]);
    }

    #[Route('/oubli-mdp/{token}', name:'reset_pass')]
    public function resetPass (
        string $token,
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        UserPasswordHasherInterface $passwordHasher): Response
    {
            // On vérifie si on a ce token dans la BDD
            $user = $userRepository->findOneByResetToken($token);
            if($user){
                $form = $this->createForm(ResetPasswordType::class);
                $form->handleRequest($request);
                
                if($form->isSubmitted() && $form->isValid()){
                    // on efface le token
                   
                    $user->setResetToken('');
                    $user->setPassword(
                        $passwordHasher->hashPassword(
                            $user,$form->get('password')->getData()
                        )
                    );
                    $em->persist($user);
                    $em->flush();
                    $this->addFlash('success','Mot de passe modifié avec succés');
                    return $this->redirectToRoute('app_login');
                }    
                return $this->render('security/reset_password.html.twig', [
                    'resetPassForm' => $form->createView()
                ]);  

            }
            $this->addFlash('danger','Jeton invalide');
            return $this->redirectToRoute('app_login');
    }
}

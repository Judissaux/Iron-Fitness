<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ChangePasswordType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class ProfilController extends AbstractController
{
    #[Route('/profil', name: 'app_profil')]
    public function index(): Response
    {   
        /** @var User $user */
        $user = $this->getUser();

        $programmes = $user->getPrograms()->getValues();
               
        $programme = [];
        foreach($programmes as $infos){
          
            $programme  [] = [ 
                'name' =>$infos->getName(),               
                'exercices' => $infos->getExercises()->getValues()                
            ];
        }    
         
        return $this->render('profil/index.html.twig',[
            'programmes' => $programme,
            
        ]);
    }

    #[Route('/profil/modification-mot-de-passe', name: 'app_modif')]
    public function changePassword(         
        UserPasswordHasherInterface $encoder,
        EntityManagerInterface $em,
        Request $request)        
    {
        /** @var User $user */
        $user= $this->getUser();

        $form = $this->createForm(ChangePasswordType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // On appelle le formulaire soumis et on récupere la données transmise dans le champs old_password
            $old_password = $form->get('old_password')->getData();

             // Méthode pour savoir si le password est valide (l'objet $user en cours et le mdp taper par l'utilisateur)
             if($encoder->isPasswordValid($user,$old_password)){
                //Ici le mot de passe en BDD et celui transmis sont pareil
                // On récupére le nouveau mot de passe 
                $new_password = $form->get('new_password')->getData();
                
                // on crypte le nouveau mdp
                $password = $encoder->hashPassword($user,$new_password);

                $user->setPassword($password);
                                
                $em->flush();

                $this->addFlash('success','Votre mot de passe à bien été modifié.');
                return $this->redirectToRoute('app_profil');

            }else{
                $this->addFlash('danger','Le mot de passe renseigné n\'est pas correct.');
            }
        }

        return $this->render("profil/changePassword.html.twig",[
            'form' => $form->createView()
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Validator\Constraints\Length;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            
            ->add('old_password', PasswordType::class, [
                'label' => 'Mot de passe actuel',                
                'mapped' => false,
                'constraints' => [
                    new NotBlank(),
                ],
                'attr' => [
                    'placeholder' => 'Saisir votre mot de passe actuel'
                ]
            ])
            
            ->add('new_password',RepeatedType::class,[
                'help' => 'Minimum 8 caractères',
                'type' => PasswordType::class,                
                'invalid_message' => 'Le mot de passe et la confirmation doivent être identique',
                'label' => 'Mot de passe',               
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Length(8, exactMessage: "Minimum 8 caractères" )
                ],
                'mapped' =>false,
                'first_options' => [
                    'help' => ' Minimum 8 caractères',
                    'label' => 'Nouveau mot de passe',
                    'attr' => ['placeholder' => 'Nouveau mot de passe']
                ],
                'second_options' => [
                    'label' => 'Confirmer le nouveau mot de passe',
                    'attr' => ['placeholder' => 'Confirmer le nouveau mot de passe']
                    ]             
             ]);          
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

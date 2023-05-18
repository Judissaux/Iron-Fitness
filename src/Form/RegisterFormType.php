<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\LessThan;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class RegisterFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sexe',ChoiceType::class,[
                'label' => 'Civilité: ',
                'choices' => [
                    'Monsieur' => 'M',
                    'Madame' => 'F'
                ],
                'expanded' => true,
                'multiple' => false,
                'label_attr' => [
                    'class' => 'radio-inline',
                ],
                'constraints' => new NotBlank()
            ])

            ->add('lastname', TextType::class,
                 ['label' => 'Nom: ',
                  'constraints' => new NotBlank()
                 ])

            ->add('firstname', TextType::class,
                 ['label' => 'Prénom: ',
                  'constraints' => new NotBlank()
                 ])
            
            ->add('birthdayDate', BirthdayType::class , [
                'label' => 'Date de naissance: ',                
                'widget' => 'single_text',
                'constraints' =>[
                    new NotBlank(),
                    new LessThan(value: '-18 years', message: 'En dessous de l\'âge minimum'),
                    new GreaterThan(value: '01/01/1920', message: " Date antérieur au 01/01/1920 non autorisée")
                ]
                
            ])

            ->add('email', EmailType::class , [
                'label' => 'E-mail: ',
                'required' => true,
                'constraints' => [
                    new NotBlank(),
                    new Regex([
                        'pattern' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+(fr|com|net)))/i',
                        'message' => "Format incorrect"]) 
                ]                       
            ])
            
            ->add('phoneNumber', TelType::class, [
                'label' => 'Numéro de téléphone: ',
                'constraints' => [
                    new NotBlank(),
                    new Length(10,exactMessage: '10 chiffres maximum et minimum'), 
                    new Regex([
                        'pattern' => '#^0[0-9]([ .-]?[0-9]{2}){4}$#',
                        'message' => "Mauvais format -> Format autorisé (10 chiffres)"])                    
                ],
                'attr' => [
                    'maxlength' => 10 ]
                ])

            ->add('acceptCgu', CheckboxType::class, [
                'label' => 'J\'accepte les <a href="/cgu" target="_blank"> conditions générales d\'utilisation </a> et j\'autorise l\'éditeur du site à collecter et traiter  mes données personnelles conformément à la politique de protection de données personnelles',
                'label_html' => true,
                'mapped' => false,
                    'required' => true,
                    'constraints' => new NotBlank(message: "Pour continuer, vous devez cocher cette case.")
                ]);
        
    }
   
}

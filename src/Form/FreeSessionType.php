<?php

namespace App\Form;

use App\Validator\SundayConstraint;
use App\Validator\TimeSlotConstraint;
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
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class FreeSessionType extends AbstractType
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

        ->add('nom', TextType::class,
             ['label' => 'Nom: ',
              'constraints' => new NotBlank(message: "Le champs 'nom' ne peut pas être vide")
            ])

        ->add('prenom', TextType::class,
             ['label' => 'Prénom: ',
              'constraints' => new NotBlank(message: "Le champs 'prénom' ne peut pas être vide")
             ])
        

        ->add('email', EmailType::class , [
            'label' => 'E-mail: ',
            'constraints' => [
                new NotBlank(),
                new Regex([
                    'pattern' => '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+(fr|com|net)))/i',
                    'message' => "Le format de l'email est incorrecte (email finissant par .net, .fr et .com seulement)"]) 
            ]       
        ])
        
        ->add('numTelephone', TelType::class, [
            'label' => 'Numéro de téléphone: ',
            'constraints' => [
                new NotBlank(),
                new Length(10), 
                new Regex([
                    'pattern' => '#^0[0-9]([ .-]?[0-9]{2}){4}$#',
                    'message' => "Mauvais format pour le téléphone -> Format autorisé (10 chiffres)"])                    
            ],
            'attr' => [
                'maxlength' => 10 ]
            ])
            ->add('datePresence',DateTimeType::class,([
                  'label' => 'Date de votre présence',
                  'widget' => 'single_text',                                   
                  'constraints' => [
                    new GreaterThan('now', message: 'La date ne peux pas être inférieur à la date du jour'),
                    new LessThan('+ 14 days', message: 'La date ne peux pas être supérieur à 14 jour à partir de la date du jour'),
                    new SundayConstraint(),
                    new TimeSlotConstraint(),
                  ],
                  'html5' => false,
                  'format' => 'yyyy-MM-dd H:m',
                  'attr' => ['class' => 'js-datepicker',
                'placeholder' => "Selectionner une date"],                                 
                ])
                
            )
            ->add('acceptCgu', CheckboxType::class, [
                'label' => 'J\'accepte les <a href="/cgu"> conditions générales d\'utilisation  </a> et j\'autorise l\'éditeur du site à collecter et traiter  mes données personnelles conformément à la politique de protection de données personnelles',
                'label_html' => true,
                'required' => true,
                'constraints' => new NotBlank(message: "Pour continuer, vous devez cocher cette case.")
            ]);
    }

    
}

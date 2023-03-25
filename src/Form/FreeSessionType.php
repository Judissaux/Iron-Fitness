<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

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
            ]
        ])

        ->add('nom', TextType::class,
             ['label' => 'Nom: '])

        ->add('prenom', TextType::class,
             ['label' => 'Prénom: '])
        

        ->add('email', EmailType::class , [
            'label' => 'E-mail: '
        ])
        
        ->add('numTelephone', TelType::class, [
            'label' => 'Numéro de téléphone: ',
            'attr' => [
                'maxlength' => 10 ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}

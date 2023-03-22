<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    private ?string $nom = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    private ?string $prenom = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    private ?string $sexe = null;

    
    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
   
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    #[Assert\LessThan(        
        value: '-18 years', message: 'En dessous de l\'âge minimum')]
    #[Assert\GreaterThan(value: '01/01/1920', message: ' Date antérieure au 01/01/1920 non autorisée')] 
    private ?\DateTimeInterface $dateNaissance = null;

    #[ORM\Column(length: 255)]
    #[Assert\Regex(
        pattern: '/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+(fr|com|net)))/i',
        message: "Format incorrect"
    )]
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    private ?string $email = null;

    #[ORM\Column(length: 50)]
    #[Assert\NotBlank(message: "Le champs ne peut pas être vide")]
    #[Assert\Length(
        min : 10,
        max : 11,
        minMessage: 'Le numéro de téléphone ne peut pas être inférieur à 10 chiffres',        
        maxMessage: 'Le numéro de téléphone ne peut pas dépasser 10 chiffres'
    )]
    #[Assert\Regex(
        pattern: ('#^0[0-9]([ .-]?[0-9]{2}){4}$#'),
        message: 'Mauvais format -> Format autorisé (10 chiffres)')]
    private ?string $numTelephone = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): self
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeInterface
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeInterface $dateNaissance): self
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getNumTelephone(): ?string
    {
        return $this->numTelephone;
    }

    public function setNumTelephone(string $numTelephone): self
    {
        $this->numTelephone = $numTelephone;

        return $this;
    }
}

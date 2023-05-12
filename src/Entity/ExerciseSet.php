<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\ExerciseSetRepository;

#[ORM\Entity(repositoryClass: ExerciseSetRepository::class)]
class ExerciseSet 
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\ManyToOne(inversedBy: 'exerciseSets')]
    private ?Exercises $exercise = null;

    #[ORM\Column(nullable: true)]
    private ?int $repetition = null;

    #[ORM\Column(nullable: true)]
    private ?int $rest = null;

    #[ORM\Column(nullable: true)]
    private ?int $series = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\ManyToOne(inversedBy: 'exercises')]
    private ?Program $program = null;

    #[ORM\Column(length: 50)]
    private ?string $day = null;

    public function __toString()
    {
       $day = "";
    switch($this->day){
        case 1:
            $day =  $this->exercise .   ' ( Lundi )';
            break;
        case 2:
            $day = $this->exercise .  ' ( Mardi )';
                break;
        case 3:
            $day = $this->exercise . ' ( Mercredi )';
                break;
        case 4:
            $day = $this->exercise .  ' ( Jeudi )';
            break;
        case 5:
            $day = $this->exercise .  ' ( Vendredi )';
            break;
        case 6:
            $day = $this->exercise .   ' ( Samedi )';
            break;
                

    }
      return $day;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercises
    {
        return $this->exercise;
    }

    public function setExercise(?Exercises $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(?int $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getRest(): ?int
    {
        return $this->rest;
    }

    public function setRest(?int $rest): self
    {
        $this->rest = $rest;

        return $this;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(?int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function setDuration(?int $duration): self
    {
        $this->duration = $duration;

        return $this;
    }

    public function getProgram(): ?Program
    {
        return $this->program;
    }

    public function setProgram(?Program $program): self
    {
        $this->program = $program;

        return $this;
    }

    public function getDay(): ?string
    {
        return $this->day;
    }

    public function setDay(string $day): self
    {
        $this->day = $day;

        return $this;
    }

   

   }

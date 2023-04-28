<?php

namespace App\Entity;

use App\Repository\ExerciseSetRepository;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\Column]
    private ?array $days = [];

    public function __toString()
    {
        return $this->exercise;
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

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(array $days): self
    {
        $this->days = $days;

        return $this;
    }
}

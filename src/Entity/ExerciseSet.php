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
    private ?Exercise $exercise = null;

    #[ORM\Column]
    private ?int $repetition = null;

    #[ORM\Column]
    private ?int $series = null;

    #[ORM\Column]
    private ?int $rest = null;

    #[ORM\ManyToOne(inversedBy: 'exercise')]
    private ?Program $program = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getExercise(): ?Exercise
    {
        return $this->exercise;
    }

    public function setExercise(?Exercise $exercise): self
    {
        $this->exercise = $exercise;

        return $this;
    }

    public function getRepetition(): ?int
    {
        return $this->repetition;
    }

    public function setRepetition(int $repetition): self
    {
        $this->repetition = $repetition;

        return $this;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getRest(): ?int
    {
        return $this->rest;
    }

    public function setRest(int $rest): self
    {
        $this->rest = $rest;

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
}

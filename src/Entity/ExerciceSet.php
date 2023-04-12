<?php

namespace App\Entity;

use App\Repository\ExerciceSetRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExerciceSetRepository::class)]
class ExerciceSet
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $id_exercice = null;

    #[ORM\Column]
    private ?int $repetition = null;

    #[ORM\Column(nullable: true)]
    private ?int $break = null;

    #[ORM\Column(nullable: true)]
    private ?int $duration = null;

    #[ORM\Column(nullable: true)]
    private ?int $series = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdExercice(): ?int
    {
        return $this->id_exercice;
    }

    public function setIdExercice(int $id_exercice): self
    {
        $this->id_exercice = $id_exercice;

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

    public function getBreak(): ?int
    {
        return $this->break;
    }

    public function setBreak(?int $break): self
    {
        $this->break = $break;

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

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(?int $series): self
    {
        $this->series = $series;

        return $this;
    }
}

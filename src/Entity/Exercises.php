<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Model\IllustrationInterface;
use Symfony\Component\Validator\Constraints as Assert;
use App\Repository\ExercisesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ExercisesRepository::class)]
class Exercises implements IllustrationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[Assert\NotBlank(                
        message: "La description doit être renseignée"
    )]
    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video = null;

    #[ORM\OneToMany(mappedBy: 'exercise', targetEntity: ExerciseSet::class)]
    private Collection $exerciseSets;

    public function __construct()
    {
        $this->exerciseSets = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->name;
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getIllustration(): ?string
    {
        return $this->illustration;
    }

    public function setIllustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getVideo(): ?string
    {
        return $this->video;
    }

    public function setVideo(?string $video): self
    {
        $this->video = $video;

        return $this;
    }

    /**
     * @return Collection<int, ExerciseSet>
     */
    public function getExerciseSets(): Collection
    {
        return $this->exerciseSets;
    }

    public function addExerciseSet(ExerciseSet $exerciseSet): self
    {
        if (!$this->exerciseSets->contains($exerciseSet)) {
            $this->exerciseSets->add($exerciseSet);
            $exerciseSet->setExercise($this);
        }

        return $this;
    }

    public function removeExerciseSet(ExerciseSet $exerciseSet): self
    {
        if ($this->exerciseSets->removeElement($exerciseSet)) {
            // set the owning side to null (unless already changed)
            if ($exerciseSet->getExercise() === $this) {
                $exerciseSet->setExercise(null);
            }
        }

        return $this;
    }

    

   
}

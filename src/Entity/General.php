<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Model\IllustrationInterface;
use App\Repository\GeneralRepository;

#[ORM\Entity(repositoryClass: GeneralRepository::class)]
class General implements IllustrationInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nameSite = null;

    #[ORM\Column(length: 255)]
    private ?string $illustration = null;

    #[ORM\Column(length: 255)]
    private ?string $ScrollingMessage = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column]
    private ?float $entrance = null;

    #[ORM\Column(length: 50)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $planning = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkFacebook = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $linkInstagram = null;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameSite(): ?string
    {
        return $this->nameSite;
    }

    public function setNameSite(string $nameSite): self
    {
        $this->nameSite = $nameSite;

        return $this;
    }

    public function getillustration(): ?string
    {
        return $this->illustration;
    }

    public function setillustration(string $illustration): self
    {
        $this->illustration = $illustration;

        return $this;
    }

    public function getScrollingMessage(): ?string
    {
        return $this->ScrollingMessage;
    }

    public function setScrollingMessage(string $ScrollingMessage): self
    {
        $this->ScrollingMessage = $ScrollingMessage;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getEntrance(): ?float
    {
        return $this->entrance;
    }

    public function setEntrance(float $entrance): self
    {
        $this->entrance = $entrance;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getPlanning(): ?string
    {
        return $this->planning;
    }

    public function setPlanning(?string $planning): self
    {
        $this->planning = $planning;

        return $this;
    }

    public function getLinkFacebook(): ?string
    {
        return $this->linkFacebook;
    }

    public function setLinkFacebook(?string $linkFacebook): self
    {
        $this->linkFacebook = $linkFacebook;

        return $this;
    }

    public function getLinkInstagram(): ?string
    {
        return $this->linkInstagram;
    }

    public function setLinkInstagram(?string $linkInstagram): self
    {
        $this->linkInstagram = $linkInstagram;

        return $this;
    }
}

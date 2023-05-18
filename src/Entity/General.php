<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $mentionLegale = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cgu = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $cgv = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $emailClient = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $emailClientRefus = null;


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

    public function getMentionLegale(): ?string
    {
        return $this->mentionLegale;
    }

    public function setMentionLegale(?string $mentionLegale): self
    {
        $this->mentionLegale = $mentionLegale;

        return $this;
    }

    public function getCgu(): ?string
    {
        return $this->cgu;
    }

    public function setCgu(?string $cgu): self
    {
        $this->cgu = $cgu;

        return $this;
    }

    public function getCgv(): ?string
    {
        return $this->cgv;
    }

    public function setCgv(?string $cgv): self
    {
        $this->cgv = $cgv;

        return $this;
    }

    public function getEmailClient(): ?string
    {
        return $this->emailClient;
    }

    public function setEmailClient(string $emailClient): self
    {
        $this->emailClient = $emailClient;

        return $this;
    }

    public function getEmailClientRefus(): ?string
    {
        return $this->emailClientRefus;
    }

    public function setEmailClientRefus(string $emailClientRefus): self
    {
        $this->emailClientRefus = $emailClientRefus;

        return $this;
    }
}

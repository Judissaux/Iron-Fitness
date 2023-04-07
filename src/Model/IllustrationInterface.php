<?php

namespace App\Model;


//création de l'interface permettant de rendant oblgatoire l'implémentation des propriété get et set illustration
interface IllustrationInterface
{
    public function getIllustration(): ?string;    

    public function setIllustration(string $illustration): self;
    

}
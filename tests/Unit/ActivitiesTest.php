<?php

namespace App\tests\Unit;

use App\Entity\Activities;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ActivitiesTest extends KernelTestCase
{
    public function testValidEntity(): void
    {
        $activities = (new Activities())
                ->setDescription('Une description de test');
                
        
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($activities);
        $this->assertCount(0,$errors);
        
    }

    public function testInvalidEntity(): void
    {
        $activities = (new Activities())
                ->setDescription('');
                
        
        self::bootKernel();
        $errors = self::getContainer()->get('validator')->validate($activities);
        $this->assertCount(1,$errors);
        
    }
}

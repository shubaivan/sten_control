<?php

namespace App\DataFixtures;

use App\Entity\Control;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ControlFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $control = new Control();
        $control
            ->setFisrtName('TestFirstName1')
            ->setLastName('TestLastName1')
            ->setMobile('0631111111')
            ->setDeviceHash('#111');
         $manager->persist($control);

        $control = new Control();
        $control
            ->setFisrtName('TestFirstName2')
            ->setLastName('TestLastName2')
            ->setMobile('0631111111')
            ->setDeviceHash('#222');
        $manager->persist($control);

        $manager->flush();
    }
}

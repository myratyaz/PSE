<?php

namespace App\DataFixtures;

use App\Entity\Info;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class InfoFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $info1 = new Info();
        $info1->setEmail("email@gmail.com");
        $info1->setName("Name1");
        $info1->setHobby("reading");
        $info1->setPhoneNumber("+432902931");
        $info1->setOccupation("student");
        $manager->persist($info1);

        $manager->flush();
    }
}

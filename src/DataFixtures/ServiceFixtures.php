<?php

namespace App\DataFixtures;

use App\Entity\Service;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ServiceFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // service1
        $service1 = new Service();
        $service1->setTitle('Design + Development');
        $service1->setContent('Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.');
        
        $manager->persist($service1);
        
        // service 2
        $service2 = new Service();
        $service2->setTitle('E-Commerce');
        $service2->setContent('Vivamus id tortor tellus. Nunc faucibus nibh vel erat dictum molestie. Vestibulum arcu orci, tristique et cursus vel, cursus nec diam. Nulla rhoncus vel eros at fringilla. Ut tempor ipsum tellus, a suscipit metus tincidunt at.');
        
        $manager->persist($service2);
        
        // service 3
        $service3 = new Service();
        $service3->setTitle('WordPress');
        $service3->setContent('Proin non venenatis mi, ac laoreet nisl. Aenean vitae metus auctor, volutpat odio ac, iaculis mi. Sed eget lectus risus. Vestibulum sit amet nulla ullamcorper, lacinia lorem eget, pharetra est.');
        
        $manager->persist($service3);

        $manager->flush();
    }
}

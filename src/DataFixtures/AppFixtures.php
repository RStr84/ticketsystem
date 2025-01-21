<?php

namespace App\DataFixtures;

use App\Factory\TicketFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        TicketFactory::createMany(100);
        UserFactory::createMany(20);
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}

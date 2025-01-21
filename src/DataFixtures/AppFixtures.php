<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Factory\TicketFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {

        $user = new User();
        $user -> setFName('Manuel');
        $user -> setLName('Martinez');
        $user ->setEmail('admin@bbq.de');
        $manager->persist($user);

        TicketFactory::createMany(100);
        UserFactory::createMany(20);

        $manager->flush();
    }
}

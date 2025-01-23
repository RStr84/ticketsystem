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

        // statisch
//        $user = new User();
//        $user -> setFName('Manuel');
//        $user -> setLName('Martinez');
//        $user ->setEmail('admin@bbq.de');
//        $manager->persist($user);

        // dynamisch, wichtig für den passwordHash → statisch geht nicht
        UserFactory::createOne(['email' => 'admin@bbq.de', 'fName' => 'Raphael', 'lName' => 'Straschewski', 'plainPassword' => 'admin', 'roles' => ['ROLE_ADMIN']]);
        UserFactory::createOne(['email' => 'sup@bbq.de', 'fName' => 'Sven', 'lName' => 'Svenson', 'plainPassword' => 'admin', 'roles' => ['ROLE_SUP']]);
        UserFactory::createOne(['email' => 'user@bbq.de', 'fName' => 'Andreas', 'lName' => 'Andreason', 'plainPassword' => 'admin']);
        TicketFactory::createMany(100);
        UserFactory::createMany(20);

        $manager->flush();
    }
}

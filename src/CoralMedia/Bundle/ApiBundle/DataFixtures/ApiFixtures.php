<?php

namespace CoralMedia\Bundle\ApiBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use CoralMedia\Bundle\SecurityBundle\Entity\User;

class ApiFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('Api')
            ->setLastName('User')
            ->setEmail('api@example.com')
            ->setRoles(['ROLE_API']);
        $user->setPassword(
            '$argon2id$v=19$m=65536,t=4,p=1$dvy3Q+/XeQK0ttOb3ZkSWw$reOdL0mWieHOyqdFkmi3S7jkRofKJiepOlFLNuUUHh8'
        );
        $user->setEnabled(true);

        $manager->persist($user);

        $manager->flush();
    }
}

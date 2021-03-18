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
            '$argon2id$v=19$m=65536,t=4,p=1$QD9POirlLAXhKOj8G8XO4g$Ag9z08AR4fWZ8NezxDcO8KwjsruVWwRBHRkF0QNqRvU'
        );
        $user->setEnabled(true);

        $manager->persist($user);

        $manager->flush();
    }
}

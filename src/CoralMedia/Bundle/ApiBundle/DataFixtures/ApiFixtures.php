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
            '$argon2id$v=19$m=65536,t=4,p=1$8zj5UQcjEhgA6H8sjiJWzw$yGX2aEDE6/m7O3t5aiDgnuXacWp5Sto11+/vuqsVWeg'
        );

        $manager->persist($user);

        $manager->flush();
    }
}

<?php

namespace CoralMedia\Bundle\SecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use CoralMedia\Bundle\SecurityBundle\Entity\User;

class SecurityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);
        $user = new User();
        $user->setFirstName('Admin')
            ->setLastName('User')
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            '$argon2id$v=19$m=65536,t=4,p=1$+HmYuIIVBcP5tXBD2IX9DQ$CLaBRiRCb9VxAiOJMkIGETacD7AA4x3L5YkVR8RE1/w'
        );

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $manager->flush();
    }
}

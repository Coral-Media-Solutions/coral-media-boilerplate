<?php

namespace CoralMedia\Bundle\DemoBundle\DataFixtures;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DemoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('Demo')
            ->setLastName('User')
            ->setEmail('demo@example.com')
            ->setRoles(['ROLE_USER']);
        $user->setPassword(
            '$argon2id$v=19$m=65536,t=4,p=1$SFWzjTQaCzN2DkoLJB5S3w$l4rwADkNDzBolYXQpv8tp+/MEhqfkawd5mCGHWyrdoE'
        );
        $user->setEnabled(true);

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $manager->flush();
    }
}

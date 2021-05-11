<?php

namespace CoralMedia\Bundle\SecurityBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use CoralMedia\Bundle\SecurityBundle\Entity\User;

class SecurityFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setFirstName('Admin')
            ->setLastName('User')
            ->setEmail('admin@example.com')
            ->setRoles(['ROLE_ADMIN']);
        $user->setPassword(
            '$argon2id$v=19$m=65536,t=4,p=1$yj3Q+yQwJa30X6xcrvm98Q$Rsq4rN70D3l8+IcMDfcwbks2qijg6gJDJcRf03f+0g8'
        );
        $user->setEnabled(true);

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $user = new User();
        $user->setFirstName('Super')
            ->setLastName('Admin')
            ->setEmail('superadmin@example.com')
            ->setRoles(['ROLE_SUPER_ADMIN']);
        $user->setPassword(
            '$argon2id$v=19$m=65536,t=4,p=1$+5+HXM1xgDhevOQiUnwlfQ$sE6zmZuFARYYS7owAyDaiuvaLrE/sQ0FtEbqLKD7tHo'
        );
        $user->setEnabled(true);

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $manager->flush();
    }
}

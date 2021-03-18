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
            '$argon2id$v=19$m=65536,t=4,p=1$TEm+eBelU7Vjl+uzMo1P1A$GpjHu4R9tCgaYAybnmsM1+QejuWUHmdJBEvVYq96Rlc'
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
            '$argon2id$v=19$m=65536,t=4,p=1$Q+Aussp7wuZ6RsXTxlr9pA$UaG1/BbBSjNXWzbtR5JR5ALMZR1RRdI1liaWAlP+0l8'
        );
        $user->setEnabled(true);

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $manager->flush();
    }
}

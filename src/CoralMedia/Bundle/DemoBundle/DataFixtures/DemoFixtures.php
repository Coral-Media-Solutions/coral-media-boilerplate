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
            '$argon2id$v=19$m=65536,t=4,p=1$h/FMpajPUDkg1eghvp56wQ$2OTxMJCNFz7SSmbxfhy/yF7Eccqvk/OPOnhLqaStqeg'
        );

        $this->addReference(sha1($user->getEmail()), $user);
        $manager->persist($user);

        $manager->flush();
    }
}

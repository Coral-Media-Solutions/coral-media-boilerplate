<?php

namespace CoralMedia\Bundle\DemoBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class DemoFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $manager->flush();
    }
}

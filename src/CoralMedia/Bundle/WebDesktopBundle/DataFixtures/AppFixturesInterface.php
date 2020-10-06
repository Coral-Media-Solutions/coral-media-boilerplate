<?php

namespace CoralMedia\Bundle\WebDesktopBundle\DataFixtures;

use Doctrine\Bundle\FixturesBundle\ORMFixtureInterface;

interface AppFixturesInterface extends ORMFixtureInterface
{
    const YAML_FILE_PATH = __DIR__ . '/../Resources/config/fixtures';

    function loadYamlData($className);
}

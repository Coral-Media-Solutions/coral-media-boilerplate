<?php


namespace CoralMedia\Component\Doctrine\ORM\Mapping;


interface ToggleableEntityInterface
{
    public function enable();

    public function disable();

    public function setEnabled(?bool $enabled): ToggleableEntityInterface;

    public function isEnabled();
}
<?php


namespace CoralMedia\Component\Resource\Model;


interface ToggleableInterface
{
    public function enable();

    public function disable();

    public function setEnabled(?bool $enabled): ToggleableInterface;

    public function isEnabled();
}
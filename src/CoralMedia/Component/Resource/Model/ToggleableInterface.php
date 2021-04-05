<?php


namespace CoralMedia\Component\Resource\Model;


interface ToggleableInterface
{
    const FIELD_NAME = 'enabled';

    public function enable();

    public function disable();

    public function setEnabled(?bool $enabled): ToggleableInterface;

    public function isEnabled();
}
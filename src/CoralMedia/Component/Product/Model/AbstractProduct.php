<?php


namespace CoralMedia\Component\Product\Model;


use CoralMedia\Component\Doctrine\ORM\Mapping\TimeStampableEntityInterface;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class AbstractProduct implements TimeStampableEntityInterface
{
    use TimeStampableTrait, ToggleableTrait;
}
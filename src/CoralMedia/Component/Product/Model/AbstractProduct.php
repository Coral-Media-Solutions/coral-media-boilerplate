<?php


namespace CoralMedia\Component\Product\Model;


use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class AbstractProduct implements ProductInterface
{
    use TimeStampableTrait, ToggleableTrait;
}
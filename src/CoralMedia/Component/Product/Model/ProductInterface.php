<?php


namespace CoralMedia\Component\Product\Model;


use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\ToggleableInterface;

interface ProductInterface extends
    TimeStampableInterface,
    ToggleableInterface
{

}
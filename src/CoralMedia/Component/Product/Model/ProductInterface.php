<?php


namespace CoralMedia\Component\Product\Model;


use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\ToggleableInterface;
use CoralMedia\Component\Resource\Model\UserableInterface;

interface ProductInterface extends
    TimeStampableInterface,
    ToggleableInterface, UserableInterface
{

}
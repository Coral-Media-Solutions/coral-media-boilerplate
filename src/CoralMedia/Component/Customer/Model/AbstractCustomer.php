<?php


namespace CoralMedia\Component\Customer\Model;


use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableInterface;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class AbstractCustomer implements TimeStampableInterface, ToggleableInterface
{
    use ToggleableTrait, TimeStampableTrait;

    protected $id;

    protected $contactName;

    protected $firstName;

    protected $lastName;
}
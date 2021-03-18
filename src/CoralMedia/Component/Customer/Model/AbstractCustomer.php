<?php


namespace CoralMedia\Component\Customer\Model;


use CoralMedia\Component\Doctrine\ORM\Mapping\TimeStampableEntityInterface;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class AbstractCustomer implements TimeStampableEntityInterface
{
    use ToggleableTrait, TimeStampableTrait;

    protected $id;

    protected $contactName;

    protected $firstName;

    protected $lastName;
}
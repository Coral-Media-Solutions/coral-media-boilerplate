<?php


namespace CoralMedia\Component\Shipping\Model;


use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class AbstractAddressee
{
    use TimeStampableTrait, ToggleableTrait;

    protected $id;

    protected $name;

    protected $contactName;

    
}
<?php


namespace CoralMedia\Component\Security\Model;

use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\ToggleableInterface;
use CoralMedia\Component\Resource\Model\UserableInterface;
use Symfony\Component\Security\Core\User\UserInterface as BaseUserInterface;

interface UserInterface extends BaseUserInterface,
    UserableInterface, TimeStampableInterface, \Serializable, ToggleableInterface
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_API = 'ROLE_API';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    const ROLE_SUPERADMIN = 'ROLE_SUPER_ADMIN';
}
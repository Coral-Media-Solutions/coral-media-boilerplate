<?php

namespace CoralMedia\Bundle\SecurityBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\SecurityBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ApiResource(routePrefix="/security")
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User extends \CoralMedia\Component\Security\Model\User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected $lastName;
}

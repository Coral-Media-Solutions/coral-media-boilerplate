<?php

namespace CoralMedia\Bundle\SecurityBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\SecurityBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *     routePrefix="/security",
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
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
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=180, unique=true)
     */
    protected $email;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="json")
     */
    protected $roles = [];

    /**
     * @Groups({"user:write"})
     * @ORM\Column(type="string")
     */
    protected $password;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=64)
     */
    protected $firstName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=64)
     */
    protected $lastName;

    /**
     * @Groups({"user:write"})
     * @SerializedName("password")
     */
    protected $plainPassword;
}

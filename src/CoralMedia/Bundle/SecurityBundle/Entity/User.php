<?php

namespace CoralMedia\Bundle\SecurityBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\SecurityBundle\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;

/**
 * @ApiResource(
 *     collectionOperations={
 *          "get" = { "security" = "is_granted('GET', object)" },
 *          "post" = { "security_post_denormalize" = "is_granted('POST', object)" }
 *     },
 *     itemOperations={
 *          "get" = { "security" = "is_granted('GET', object)" },
 *          "put" = { "security" = "is_granted('PUT', object)" },
 *          "patch" = { "security" = "is_granted('PATCH', object)" },
 *          "delete" = { "security" = "is_granted('DELETE', object)" }
 *     },
 *     routePrefix="/security",
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="security_users")
 */
class User extends \CoralMedia\Component\Security\Model\User implements UserInterface
{
    /**
     * @Groups({"user:read", "user:write"})
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

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\ManyToMany(targetEntity=Group::class, inversedBy="users")
     */
    protected $groups;
}

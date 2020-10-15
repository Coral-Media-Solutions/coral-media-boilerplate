<?php


namespace CoralMedia\Bundle\SecurityBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;
use CoralMedia\Bundle\SecurityBundle\Repository\GroupRepository;
use Symfony\Component\Serializer\Annotation\Groups;

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
 *     normalizationContext={"groups"={"sg:read"}},
 *     denormalizationContext={"groups"={"sg:write"}},
 * )
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="security_groups")
 */
class Group extends \CoralMedia\Component\Security\Model\Group
{
    /**
     * @Groups({"sg:read", "sg:write"})
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @Groups({"sg:read", "sg:write"})
     * @ORM\Column(type="string", length=64, unique=true)
     */
    protected $name;

    /**
     * @Groups({"sg:read", "sg:write"})
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="groups")
     */
    protected $users;

}
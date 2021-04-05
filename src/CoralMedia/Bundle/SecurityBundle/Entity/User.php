<?php

namespace CoralMedia\Bundle\SecurityBundle\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\SecurityBundle\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Serializer\Annotation\SerializedName;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ApiResource(
 *     attributes={"security"="is_granted('ROLE_API')"},
 *     collectionOperations={
 *          "get" = { "security" = "is_granted('GET', 'ROLE_API')" },
 *          "post" = { "security_post_denormalize" = "is_granted('POST', object)" },
 *     },
 *     itemOperations={
 *          "get" = { "security" = "is_granted('GET', 'ROLE_API')" },
 *          "put" = { "security" = "is_granted('PUT', object)" },
 *          "patch" = { "security" = "is_granted('PATCH', object)" },
 *          "delete" = { "security" = "is_granted('DELETE', object)" },
 *     },
 *     routePrefix="/security",
 *     normalizationContext={"groups"={"user:read"}},
 *     denormalizationContext={"groups"={"user:write"}},
 * )
 * @ApiFilter(SearchFilter::class, properties={"email": "partial", "firstName": "partial", "lastName": "partial"})
 * @ApiFilter(DateFilter::class, properties={"createdAt"})
 * @ApiFilter(
 *     OrderFilter::class,
 *     properties={ "email", "firstName", "lastName", "createdAt" },
 *     arguments={ "orderParameterName"="order" }
 * )
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`security_users`")
 * @Vich\Uploadable()
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
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    protected $firstName;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="string", length=64, nullable=true)
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

    /**
     * @Groups({"user:read"})
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @Groups({"user:read"})
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @Groups({"user:read"})
     * @ORM\ManyToOne(targetEntity="CoralMedia\Bundle\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * @Groups({"user:read"})
     * @ORM\ManyToOne(targetEntity="CoralMedia\Bundle\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     * @Groups({"user:read", "user:write"})
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $image;

    /**
     * @Vich\UploadableField(mapping="users", fileNameProperty="image")
     */
    protected $imageFile;
}

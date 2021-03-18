<?php


namespace CoralMedia\Component\Api\Security\Model;

use ApiPlatform\Core\Action\NotFoundAction;
use ApiPlatform\Core\Annotation\ApiProperty;
use ApiPlatform\Core\Annotation\ApiResource;

/**
 * Class Resource
 * @package CoralMedia\Component\Security\Model
 * @ApiResource(
 *     collectionOperations={
 *          "get" = {
 *              "security" = "is_granted('GET', object)"
 *          }
 *     },
 *     itemOperations={
 *          "get"={
 *             "controller"=NotFoundAction::class,
 *             "read"=true,
 *             "output"=false,
 *         },
 *     },
 *     routePrefix="/security",
 *     attributes={"pagination_enabled"=false}
 * )
 */
final class Resource
{
    /**
     * @ApiProperty(identifier=true)
     * @var string
     */
    protected $id;

    /**
     * @var string
     */
    protected $className;

    /**
     * @return null|string
     */
    public function getId():?string
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getClassName()
    {
        return $this->className;
    }

    /**
     * @param mixed $className
     * @return Resource
     */
    public function setClassName($className)
    {
        $this->className = $className;
        $this->id = sha1($className);
        return $this;
    }
}
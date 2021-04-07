<?php

namespace CoralMedia\Bundle\ProductBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Component\Product\Model\AbstractProduct;
use Doctrine\ORM\Mapping as ORM;
use CoralMedia\Bundle\ProductBundle\Repository\ProductRepository;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @ORM\Table(name="product_products")
 */
class Product extends AbstractProduct
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, unique=true)
     */
    protected $sku;

    /**
     * @ORM\Column(type="string", length=128, unique=true)
     */
    protected $name;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity=Product::class, mappedBy="parent")
     */
    protected $children;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="CoralMedia\Bundle\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="created_by", referencedColumnName="id", nullable=true)
     */
    protected $createdBy;

    /**
     * @ORM\ManyToOne(targetEntity="CoralMedia\Bundle\SecurityBundle\Entity\User")
     * @ORM\JoinColumn(name="updated_by", referencedColumnName="id", nullable=true)
     */
    protected $updatedBy;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;


}

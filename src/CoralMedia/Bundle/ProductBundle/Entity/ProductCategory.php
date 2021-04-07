<?php

namespace CoralMedia\Bundle\ProductBundle\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use CoralMedia\Bundle\ProductBundle\Repository\ProductCategoryRepository;
use CoralMedia\Component\Product\Model\AbstractProductCategory;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ApiResource()
 * @ORM\Entity(repositoryClass=ProductCategoryRepository::class)
 * @ORM\Table(name="product_product_categories")
 */
class ProductCategory extends AbstractProductCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=false)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=16, nullable=false)
     */
    protected $code;

    /**
     * @ORM\Column(type="boolean")
     */
    protected $enabled;

    /**
     * @ORM\ManyToOne(targetEntity=ProductCategory::class, inversedBy="children")
     */
    protected $parent;

    /**
     * @ORM\OneToMany(targetEntity=ProductCategory::class, mappedBy="parent")
     */
    protected $children;

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
}

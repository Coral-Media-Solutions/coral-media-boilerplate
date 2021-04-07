<?php


namespace CoralMedia\Component\Product\Model;


use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableTrait;
use CoralMedia\Component\Resource\Model\UserableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractProduct implements ProductInterface
{
    use TimeStampableTrait, ToggleableTrait, UserableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $sku;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var ProductInterface
     */
    protected $parent;

    /**
     * @var ArrayCollection
     */
    protected $children;

    /**
     * @var ArrayCollection
     */
    protected $categories;


    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->categories = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     * @return AbstractProduct
     */
    public function setSku($sku): ProductInterface
    {
        $this->sku = $sku;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return AbstractProduct
     */
    public function setName($name): ProductInterface
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return AbstractProduct
     */
    public function setDescription($description): ProductInterface
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * @param mixed $parent
     * @return AbstractProduct
     */
    public function setParent($parent): ProductInterface
    {
        $this->parent = $parent;
        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(self $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setParent($this);
        }

        return $this;
    }

    public function removeChild(self $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getParent() === $this) {
                $child->setParent(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->getSku() . ' - ' . $this->getName();
    }

}
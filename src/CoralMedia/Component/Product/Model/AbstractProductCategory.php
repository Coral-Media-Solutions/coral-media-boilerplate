<?php


namespace CoralMedia\Component\Product\Model;

use CoralMedia\Component\Resource\Model\ToggleableInterface;
use CoralMedia\Component\Resource\Model\ToggleableTrait;
use CoralMedia\Component\Resource\Model\UserableInterface;
use CoralMedia\Component\Resource\Model\UserableTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

abstract class AbstractProductCategory implements ToggleableInterface, UserableInterface
{
    use ToggleableTrait, UserableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var AbstractProductCategory
     */
    protected $parent;

    /**
     * @var ArrayCollection
     */
    protected $products;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->products = new ArrayCollection();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return AbstractProductCategory
     */
    public function setName(string $name): AbstractProductCategory
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * @param string $code
     * @return AbstractProductCategory
     */
    public function setCode(string $code): AbstractProductCategory
    {
        $this->code = $code;
        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
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
        return $this->getCode() . ' - ' . $this->getName();
    }

}
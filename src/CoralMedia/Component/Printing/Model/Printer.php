<?php


namespace CoralMedia\Component\Printing\Model;

use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;
use CoralMedia\Component\Resource\Model\ToggleableInterface;
use CoralMedia\Component\Resource\Model\ToggleableTrait;

abstract class Printer implements TimeStampableInterface, ToggleableInterface
{
    use TimeStampableTrait, ToggleableTrait;

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
     * @var string
     */
    protected $description;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
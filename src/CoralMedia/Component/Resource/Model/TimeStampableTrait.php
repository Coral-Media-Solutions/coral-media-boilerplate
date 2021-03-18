<?php

declare(strict_types=1);

namespace CoralMedia\Component\Resource\Model;

use CoralMedia\Component\Doctrine\ORM\Mapping\TimeStampableEntityInterface;
use DateTimeInterface;

trait TimeStampableTrait
{
    /** @var DateTimeInterface|null */
    protected $createdAt;

    /** @var DateTimeInterface|null */
    protected $updatedAt;

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): TimeStampableEntityInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampableEntityInterface
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
<?php

declare(strict_types=1);

namespace CoralMedia\Component\Resource\Model;

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

    /**
     * @param DateTimeInterface|null $createdAt
     * @return TimeStampableInterface|TimeStampableTrait
     */
    public function setCreatedAt(?DateTimeInterface $createdAt):TimeStampableInterface
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return DateTimeInterface|null
     */
    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTimeInterface|null $updatedAt
     * @return TimeStampableInterface|TimeStampableTrait
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampableInterface
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }
}
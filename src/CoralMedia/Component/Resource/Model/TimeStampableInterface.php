<?php


namespace CoralMedia\Component\Resource\Model;

use DateTimeInterface;

interface TimeStampableInterface
{
    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface|null $createdAt
     * @return TimeStampableInterface
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): TimeStampableInterface;

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface|null $updatedAt
     * @return TimeStampableInterface
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampableInterface;
}
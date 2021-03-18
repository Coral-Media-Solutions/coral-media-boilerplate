<?php


namespace CoralMedia\Component\Doctrine\ORM\Mapping;

use DateTimeInterface;

interface TimeStampableEntityInterface
{
    /**
     * @return DateTimeInterface
     */
    public function getCreatedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface|null $createdAt
     * @return TimeStampableEntityInterface
     */
    public function setCreatedAt(?DateTimeInterface $createdAt): TimeStampableEntityInterface;

    /**
     * @return DateTimeInterface
     */
    public function getUpdatedAt(): ?DateTimeInterface;

    /**
     * @param DateTimeInterface|null $updatedAt
     * @return TimeStampableEntityInterface
     */
    public function setUpdatedAt(?DateTimeInterface $updatedAt): TimeStampableEntityInterface;
}
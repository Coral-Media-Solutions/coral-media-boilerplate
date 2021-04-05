<?php


namespace CoralMedia\Component\Resource\Model;

use CoralMedia\Component\Security\Model\UserInterface;

interface UserableInterface
{
    /**
     * @return UserInterface
     */
    public function getCreatedBy(): ?UserInterface;

    /**
     * @param UserInterface $createdBy
     * @return UserableInterface
     */
    public function setCreatedBy(UserInterface $createdBy): UserableInterface;

    /**
     * @return UserInterface
     */
    public function getUpdatedBy(): ?UserInterface;

    /**
     * @param UserInterface $updatedBy
     * @return UserableInterface
     */
    public function setUpdatedBy(UserInterface $updatedBy): UserableInterface;
}
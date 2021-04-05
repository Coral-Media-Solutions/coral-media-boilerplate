<?php


namespace CoralMedia\Component\Resource\Model;


use CoralMedia\Component\Security\Model\UserInterface;

trait UserableTrait
{
    /**
     * @var UserInterface
     */
    protected $createdBy;

    /**
     * @var UserInterface
     */
    protected $updatedBy;

    /**
     * @return UserInterface|null
     */
    public function getCreatedBy(): ?UserInterface
    {
        return $this->createdBy;
    }

    /**
     * @param UserInterface $createdBy
     * @return UserableInterface|UserableTrait
     */
    public function setCreatedBy(UserInterface $createdBy): UserableInterface
    {
        $this->createdBy = $createdBy;
        return $this;
    }

    /**
     * @return UserInterface|null
     */
    public function getUpdatedBy(): ?UserInterface
    {
        return $this->updatedBy;
    }

    /**
     * @param UserInterface $updatedBy
     * @return UserableInterface|UserableTrait
     */
    public function setUpdatedBy(UserInterface $updatedBy): UserableInterface
    {
        $this->updatedBy = $updatedBy;
        return $this;
    }


}
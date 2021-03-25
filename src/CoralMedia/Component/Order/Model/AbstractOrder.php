<?php


namespace CoralMedia\Component\Order\Model;

use CoralMedia\Component\Resource\Model\StatusableTrait;
use CoralMedia\Component\Resource\Model\TimeStampableInterface;
use CoralMedia\Component\Resource\Model\TimeStampableTrait;

abstract class AbstractOrder implements TimeStampableInterface
{
    use TimeStampableTrait, StatusableTrait;

    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $code;

    /**
     * @var string
     */
    protected $reference;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
     * @return AbstractOrder
     */
    public function setCode(string $code): AbstractOrder
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return string
     */
    public function getReference(): string
    {
        return $this->reference;
    }

    /**
     * @param string $reference
     * @return AbstractOrder
     */
    public function setReference(string $reference): AbstractOrder
    {
        $this->reference = $reference;
        return $this;
    }
}
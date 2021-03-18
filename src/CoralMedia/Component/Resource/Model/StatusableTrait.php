<?php


namespace CoralMedia\Component\Resource\Model;


trait StatusableTrait
{
    /**
     * @var int
     */
    protected $status;

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     * @return StatusableTrait
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }
}
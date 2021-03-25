<?php

declare(strict_types=1);

namespace CoralMedia\Component\Resource\Model;


trait ToggleableTrait
{
    /** @var bool */
    protected $enabled = true;

    public function isEnabled(): bool
    {
        return $this->enabled;
    }

    /**
     * @param bool $enabled
     * @return ToggleableInterface
     */
    public function setEnabled(?bool $enabled): ToggleableInterface
    {
        $this->enabled = (bool) $enabled;
        return $this;
    }

    public function enable(): void
    {
        $this->enabled = true;
    }

    public function disable(): void
    {
        $this->enabled = false;
    }
}
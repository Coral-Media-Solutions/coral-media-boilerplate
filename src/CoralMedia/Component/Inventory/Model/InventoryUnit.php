<?php

declare(strict_types=1);

namespace CoralMedia\Component\Inventory\Model;

class InventoryUnit implements InventoryUnitInterface
{
    /** @var mixed */
    protected $id;

    /** @var StockableInterface|null */
    protected $stockable;

    public function getId()
    {
        return $this->id;
    }

    public function getStockable(): ?StockableInterface
    {
        return $this->stockable;
    }

    public function setStockable(StockableInterface $stockable): void
    {
        $this->stockable = $stockable;
    }
}

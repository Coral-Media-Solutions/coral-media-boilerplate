<?php


namespace CoralMedia\Component\Printing\Api;


use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use CoralMedia\Component\Printing\Model\PrintingBatchFileInterface;

class PrintingBatchFileDataPersister
{
    protected $decoratedDataPersister;

    /**
     * @param DataPersisterInterface $decoratedDataPersister
     */
    public function __construct(DataPersisterInterface $decoratedDataPersister)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
    }

    public function supports($data): bool
    {
        return ($data instanceof PrintingBatchFileInterface);
    }

    public function persist($data): object
    {
        return $this->decoratedDataPersister->persist($data);
    }

    public function remove($data)
    {
        return $this->decoratedDataPersister->remove($data);
    }
}
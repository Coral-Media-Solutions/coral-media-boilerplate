<?php


namespace CoralMedia\Component\Api\Security\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use CoralMedia\Component\Security\Model\Group;

class GroupDataPersister implements DataPersisterInterface
{

    protected $decoratedDataPersister;

    /**
     * UserDataPersister constructor.
     * @param DataPersisterInterface $decoratedDataPersister
     */
    public function __construct(DataPersisterInterface $decoratedDataPersister)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
    }

    /**
     * @param Group $data
     * @return bool
     */
    public function supports($data): bool
    {
        return ($data instanceof Group);
    }

    /**
     * @param Group $data
     * @return object|void
     */
    public function persist($data)
    {
        $this->decoratedDataPersister->persist($data);
    }

    /**
     * @param Group $data
     * @return mixed
     */
    public function remove($data)
    {
        $this->decoratedDataPersister->remove($data);
    }
}
<?php


namespace CoralMedia\Component\Api\Security\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use CoralMedia\Component\Security\Model\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserDataPersister implements DataPersisterInterface
{

    protected $decoratedDataPersister;
    protected $passwordEncoder;

    /**
     * UserDataPersister constructor.
     * @param DataPersisterInterface $decoratedDataPersister
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(DataPersisterInterface $decoratedDataPersister,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->decoratedDataPersister = $decoratedDataPersister;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User|UserInterface $data
     * @return bool
     */
    public function supports($data): bool
    {
        return ($data instanceof UserInterface);
    }

    /**
     * @param User|UserInterface $data
     * @return object|void
     */
    public function persist($data): object
    {
        if($data->getPlainPassword()) {
            $data->setPassword(
                $this->passwordEncoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }
        return $this->decoratedDataPersister->persist($data);
    }

    /**
     * @param User|UserInterface $data
     * @param array $context
     * @return mixed
     */
    public function remove($data, array $context = [])
    {
        return $this->decoratedDataPersister->remove($data);
    }
}
<?php


namespace CoralMedia\Bundle\ApiBundle\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use CoralMedia\Component\Security\Model\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserDataPersister implements ContextAwareDataPersisterInterface
{

    protected $decorated;
    protected $passwordEncoder;

    /**
     * UserDataPersister constructor.
     * @param ContextAwareDataPersisterInterface $decorated
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(ContextAwareDataPersisterInterface $decorated,
                                UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->decorated = $decorated;
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @param User|UserInterface $data
     * @param array $context
     * @return bool
     */
    public function supports($data, array $context = []): bool
    {
        return $this->decorated->supports($data, $context);
    }

    /**
     * @param User|UserInterface $data
     * @param array $context
     * @return object|void
     */
    public function persist($data, array $context = [])
    {
        if($data->getPlainPassword()) {
            $data->setPassword(
                $this->passwordEncoder->encodePassword($data, $data->getPlainPassword())
            );
            $data->eraseCredentials();
        }
        return $this->decorated->persist($data, $context);
    }

    /**
     * @param User|UserInterface $data
     * @param array $context
     * @return mixed
     */
    public function remove($data, array $context = [])
    {
        return $this->decorated->remove($data, $context);
    }
}
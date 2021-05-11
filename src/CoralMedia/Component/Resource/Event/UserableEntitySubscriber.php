<?php


namespace CoralMedia\Component\Resource\Event;

use CoralMedia\Bundle\SecurityBundle\Entity\User;
use CoralMedia\Component\Resource\Model\UserableInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class UserableEntitySubscriber implements EventSubscriber
{
    private $_tokenStorage;
    private $_entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $entityManager)
    {
        $this->_tokenStorage = $tokenStorage;
        $this->_entityManager = $entityManager;
    }

    /**
     * @return array
     */
    public function getSubscribedEvents(): array
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /**
         * @var UserableInterface
         */
        $entity = $args->getEntity();

        if(!$entity instanceof UserableInterface){
            return;
        }

        if (!is_null($this->_tokenStorage->getToken())) {
            $userToken = $this->_tokenStorage->getToken()->getUser();
            $userEntity = $this->_entityManager->getRepository(User::class)
                ->findOneBy(['email' => $userToken->getUsername()]);


            $entity->setCreatedBy($userEntity);
            $entity->setUpdatedBy($userEntity);
        }
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        /**
         * @var UserableInterface
         */
        $entity = $args->getEntity();

        if(!$entity instanceof UserableInterface){
            return;
        }

        if (!is_null($this->_tokenStorage->getToken())) {
            $userToken = $this->_tokenStorage->getToken()->getUser();
            $userEntity = $this->_entityManager->getRepository(User::class)
                ->findOneBy(['email' => $userToken->getUsername()]);

            $entity->setUpdatedBy($userEntity);
        }
    }
}
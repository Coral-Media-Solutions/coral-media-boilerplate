<?php


namespace CoralMedia\Component\Api\Security\Event;


use ApiPlatform\Core\EventListener\EventPriorities;
use CoralMedia\Bundle\SecurityBundle\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class CurrentUserSubscriber implements EventSubscriberInterface
{
    private $_tokenStorage;
    private $_entityManager;

    public function __construct(TokenStorageInterface $tokenStorage, EntityManagerInterface $_entityManager)
    {
        $this->_tokenStorage = $tokenStorage;
        $this->_entityManager =$_entityManager;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['resolveMe', EventPriorities::PRE_READ],
        ];
    }

    public function resolveMe(RequestEvent $event)
    {
        $request = $event->getRequest();

        if ('api_users_get_item' !== $request->attributes->get('_route')) {
            return;
        }

        if ('me' !== $request->attributes->get('id')) {
            return;
        }

        $userToken = $this->_tokenStorage->getToken()->getUser();
        if (!$userToken instanceof UserInterface) {
            return;
        }

        $userEntity = $this->_entityManager->getRepository(User::class)
            ->findOneBy(['email' => $userToken->getUsername()]);

        $request->attributes->set('id', $userEntity->getId());
    }
}
<?php


namespace CoralMedia\Component\Api\Security\Token\Logout\Event;

use CoralMedia\Component\Security\Model\User;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Exception;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;

final class LogoutEventSubscriber implements EventSubscriberInterface
{
    /** @var Connection */
    private $databaseConnection;

    public function __construct(Connection $databaseConnection)
    {
        $this->databaseConnection = $databaseConnection;
    }

    /**
     * @param LogoutEvent $event
     * @throws Exception
     */
    public function onLogout(LogoutEvent $event): void
    {
        $authenticatedUser = $event->getToken()->getUser();

        $event->getRequest()->getSession()->invalidate();

        if (null === $authenticatedUser) {
            return;
        }

        $this->databaseConnection->createQueryBuilder()
            ->delete('refresh_tokens')
            ->where('username=:username')
            ->setParameter('username', $authenticatedUser->getUsername())
            ->execute()
        ;
    }

    public static function getSubscribedEvents()
    {
        return [
            LogoutEvent::class => 'onLogout',
        ];
    }
}
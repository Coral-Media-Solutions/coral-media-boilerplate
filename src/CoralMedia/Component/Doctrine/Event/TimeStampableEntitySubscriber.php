<?php


namespace CoralMedia\Component\Doctrine\Event;


use CoralMedia\Component\Doctrine\ORM\Mapping\TimeStampableEntityInterface;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;
use Doctrine\ORM\Events;

class TimeStampableEntitySubscriber implements EventSubscriber
{

    public function getSubscribedEvents()
    {
        return [
            Events::prePersist,
            Events::preUpdate,
        ];
    }

    public function prePersist(LifecycleEventArgs $args)
    {
        /**
         * @var TimeStampableEntityInterface
         */
        $entity = $args->getEntity();

        if(!$entity instanceof TimeStampableEntityInterface){
            return;
        }
        $currentDateTime = new \DateTime();
        $entity->setCreatedAt($currentDateTime);
        $entity->setUpdatedAt($currentDateTime);
    }

    public function preUpdate(LifecycleEventArgs $args)
    {
        /**
         * @var TimeStampableEntityInterface
         */
        $entity = $args->getEntity();

        if(!$entity instanceof TimeStampableEntityInterface){
            return;
        }
        $currentDateTime = new \DateTime();
        $entity->setUpdatedAt($currentDateTime);
    }
}
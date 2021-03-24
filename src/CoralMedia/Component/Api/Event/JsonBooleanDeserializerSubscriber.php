<?php


namespace CoralMedia\Component\Api\Event;


use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class JsonBooleanDeserializerSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::REQUEST => ['deserializeBoolean', EventPriorities::PRE_DESERIALIZE]
        ];
    }

    public function deserializeBoolean(RequestEvent $event)
    {
        $request = $event->getRequest();
        if(($request->getMethod() === Request::METHOD_POST ||
                $request->getMethod() === Request::METHOD_PATCH ||
                $request->getMethod() === Request::METHOD_PUT) &&
            $request->getRequestFormat() === 'jsonld') {

            $session = $request->getSession();
            $format = $request->getRequestFormat();
            $method = $request->getMethod();
            $locale = $request->getLocale();

            $data = json_decode($request->getContent(), true);
            $data['enabled'] = ($data['enabled'] === "false" || $data['enabled'] === "0") ? false : true;

            $request->initialize(
                $request->query->all(),
                $request->request->all(),
                $request->attributes->all(),
                $request->cookies->all(),
                $request->files->all(),
                $request->server->all(),
                json_encode($data)
            );

            $request->setRequestFormat($format);
            $request->setMethod($method);
            $request->setSession($session);
            $request->setLocale($locale);
        }
    }
}
<?php

namespace App\EventListener;

use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTCreatedEvent;
use Symfony\Component\HttpFoundation\RequestStack;

class JWTCreatedListener
{
    public function onJWTCreated(JWTCreatedEvent $event)
    {
        $user = $event->getUser();
        $payload = $event->getData();

        // Ajoutez l'ID de l'utilisateur au payload
        $payload['user_id'] = $user->getId()??0;

        $event->setData($payload);
    }
}

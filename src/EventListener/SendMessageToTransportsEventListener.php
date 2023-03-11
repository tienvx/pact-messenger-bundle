<?php

namespace Tienvx\Bundle\PactMessengerBundle\EventListener;

use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;

class SendMessageToTransportsEventListener
{
    public function __construct(private EnvelopeCollectorInterface $collector)
    {
    }

    public function __invoke(SendMessageToTransportsEvent $event): void
    {
        $this->collector->collect(
            $event->getEnvelope(),
            method_exists($event, 'getSenders') ? array_keys($event->getSenders()) : null
        );
    }
}

<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Tienvx\Bundle\PactMessengerBundle\EventListener\SendMessageToTransportsEventListener;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollector;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;

return static function (ContainerConfigurator $container): void {
    $container->services()
        ->set(EnvelopeCollector::class)
            ->alias(EnvelopeCollectorInterface::class, EnvelopeCollector::class)

        ->set(SendMessageToTransportsEventListener::class)
            ->args([
                EnvelopeCollectorInterface::class,
            ])
            ->tag('kernel.event_listener')
    ;
};

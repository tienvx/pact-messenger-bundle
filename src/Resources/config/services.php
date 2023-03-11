<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

use Tienvx\Bundle\PactMessengerBundle\EventListener\SendMessageToTransportsEventListener;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollector;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;

return static function (ContainerConfigurator $container): void {
    $namespace = __NAMESPACE__;
    $service = function_exists("$namespace\\service") ? "$namespace\\service" : "$namespace\\ref";
    $container->services()
        ->set(EnvelopeCollector::class)
            ->alias(EnvelopeCollectorInterface::class, EnvelopeCollector::class)

        ->set(SendMessageToTransportsEventListener::class)
            ->args([
                $service(EnvelopeCollectorInterface::class),
            ])
            ->tag('kernel.event_listener')
    ;
};

<?php

namespace Symfony\Component\DependencyInjection\Loader\Configurator;

return static function (ContainerConfigurator $container) {
    $services = $container->services()
        ->defaults()
            ->autowire()
            ->autoconfigure()
    ;

    $services->load('Tienvx\\Bundle\\PactMessengerBundle\\Tests\\Integration\\TestApplication\\', '../src/*')
        ->exclude('../{Entity,Tests,Kernel.php}');
};
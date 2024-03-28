<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Kernel;

return function (RoutingConfigurator $routes) {
    $routes->import('../src/Controller/', Kernel::MAJOR_VERSION >= 6 ? 'attribute' : 'annotation');
};

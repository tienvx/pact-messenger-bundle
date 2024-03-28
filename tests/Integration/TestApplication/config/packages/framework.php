<?php

use Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Kernel;

$configuration = [
    'http_method_override' => false,
    'handle_all_throwables' => true,
    'php_errors' => [
        'log' => true,
    ],
    'test' => true,
    'messenger' => [
        'transports' => [
            'async' => 'in-memory://',
            'audit' => 'in-memory://',
        ],
        'routing' => [
            'Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserCreated' => 'async',
            'Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserUpdated' => 'async',
            'Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserDeleted' => ['async', 'audit'],
        ],
    ],
];

if (Kernel::MAJOR_VERSION <= 5) {
    unset($configuration['handle_all_throwables']);
}

$container->loadFromExtension('framework', $configuration);

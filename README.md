# Pact Messenger Bundle [![Build Status][actions_badge]][actions_link] [![Coverage Status][coveralls_badge]][coveralls_link] [![Version][version-image]][version-url] [![PHP Version][php-version-image]][php-version-url]

This Symfony Bundle allow collecting dispatched message using [Symfony Messenger][messenger].

## Installation

```shell
composer require tienvx/pact-messenger-bundle
```

## Documentation

```php

namespace App\MessageDispatcher;

use App\Message\UserCreated;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;
use Tienvx\Bundle\PactProviderBundle\Attribute\AsMessageDispatcher;
use Tienvx\Bundle\PactProviderBundle\Model\Message;
use Tienvx\Bundle\PactProviderBundle\MessageDispatcher\DispatcherInterface;

#[AsMessageDispatcher(description: 'User created message')]
class UserDispatcher implements DispatcherInterface
{
    public function __construct(private EnvelopeCollectorInterface $collector)
    {
    }

    public function dispatch(): ?Message
    {
        $envelope = $this->collector->getSingle(UserCreated::class);
        if (!$envelope) {
            return null;
        }
        $message = $envelope->getMessage();
        if (!$message instanceof UserCreated) {
            return null;
        }

        return new Message(
            \json_encode([
                'class' => UserCreated::class,
                'id' => $message->userId,
            ]),
            'application/json',
            json_encode(['contentType' => 'application/json'])
        );
    }
}
```

## License

[MIT](https://github.com/tienvx/pact-messenger-bundle/blob/main/LICENSE)

[actions_badge]: https://github.com/tienvx/pact-messenger-bundle/workflows/main/badge.svg
[actions_link]: https://github.com/tienvx/pact-messenger-bundle/actions

[coveralls_badge]: https://coveralls.io/repos/tienvx/pact-messenger-bundle/badge.svg?branch=main&service=github
[coveralls_link]: https://coveralls.io/github/tienvx/pact-messenger-bundle?branch=main

[version-url]: https://packagist.org/packages/tienvx/pact-messenger-bundle
[version-image]: http://img.shields.io/packagist/v/tienvx/pact-messenger-bundle.svg?style=flat

[php-version-url]: https://packagist.org/packages/tienvx/pact-messenger-bundle
[php-version-image]: http://img.shields.io/badge/php-8.1.0+-ff69b4.svg

[messenger]: https://github.com/symfony/messenger

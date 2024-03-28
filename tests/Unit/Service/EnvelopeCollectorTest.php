<?php

namespace Tienvx\Bundle\PactProviderBundle\Tests\Unit\Service;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Tienvx\Bundle\PactMessengerBundle\Exception\LogicException;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollector;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserCreated;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserDeleted;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserUpdated;

class EnvelopeCollectorTest extends TestCase
{
    private EnvelopeCollectorInterface $collector;

    protected function setUp(): void
    {
        $this->collector = new EnvelopeCollector();
    }

    public function testGetAll(): void
    {
        $this->collector->collect($create = new Envelope(new UserCreated(123)));
        $this->collector->collect($update = new Envelope(new UserUpdated(123)));
        $this->collector->collect($delete = new Envelope(new UserDeleted(123)));
        $this->assertSame([$create, $update, $delete], $this->collector->getAll());
    }

    public function testSingleWithoutTransport(): void
    {
        $this->collector->collect($create = new Envelope(new UserCreated(123)));
        $this->collector->collect($update = new Envelope(new UserUpdated(123)));
        $this->collector->collect($delete = new Envelope(new UserDeleted(123)));
        $this->assertSame($create, $this->collector->getSingle(UserCreated::class));
    }

    public function testSingleWithTransportThrowException(): void
    {
        $this->collector->collect($create = new Envelope(new UserCreated(123)));
        $this->collector->collect($update = new Envelope(new UserUpdated(123)));
        $this->collector->collect($delete = new Envelope(new UserDeleted(123)));
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('You need to upgrade to Symfony >=6.2 to be able to filter envelope by transport.');
        $this->collector->getSingle(UserCreated::class, 'async');
    }

    public function testSingleWithTransportFound(): void
    {
        $this->collector->collect($create = new Envelope(new UserCreated(123)), ['async']);
        $this->collector->collect($update = new Envelope(new UserUpdated(123)), ['async']);
        $this->collector->collect($delete = new Envelope(new UserDeleted(123)), ['async', 'audit']);
        $this->assertSame($delete, $this->collector->getSingle(UserDeleted::class, 'audit'));
    }

    public function testSingleWithTransportNotFound(): void
    {
        $this->collector->collect($create = new Envelope(new UserCreated(123)), ['async']);
        $this->collector->collect($update = new Envelope(new UserUpdated(123)), ['async']);
        $this->collector->collect($delete = new Envelope(new UserDeleted(123)), ['async', 'audit']);
        $this->assertNull($this->collector->getSingle(UserUpdated::class, 'audit'));
    }
}

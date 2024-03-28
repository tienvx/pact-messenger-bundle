<?php

namespace Tienvx\Bundle\MbtBundle\Tests\Integration\Service;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\MessageBusInterface;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;
use Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserCreated;
use Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserDeleted;
use Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message\UserUpdated;

class EnvelopeCollectorTest extends KernelTestCase
{
    private int $id = 123;

    public function testEnvelopCollector(): void
    {
        self::bootKernel();

        $container = static::getContainer();

        $bus = $container->get(MessageBusInterface::class);
        $bus->dispatch(new UserCreated($this->id));
        $bus->dispatch(new UserUpdated($this->id));
        $bus->dispatch(new UserDeleted($this->id));

        $collector = $container->get(EnvelopeCollectorInterface::class);
        $this->assertCount(3, $all = $collector->getAll());

        $this->assertInstanceOf(Envelope::class, $created = $collector->getSingle(UserCreated::class));
        $this->assertTrue(in_array($created, $all));
        $this->assertInstanceOf(UserCreated::class, $message = $created->getMessage());
        $this->assertSame($this->id, $message->userId);
        $this->assertInstanceOf(Envelope::class, $updated = $collector->getSingle(UserUpdated::class));
        $this->assertTrue(in_array($updated, $all));
        $this->assertInstanceOf(UserUpdated::class, $message = $updated->getMessage());
        $this->assertSame($this->id, $message->userId);
        $this->assertInstanceOf(Envelope::class, $deleted = $collector->getSingle(UserDeleted::class));
        $this->assertTrue(in_array($deleted, $all));
        $this->assertInstanceOf(UserDeleted::class, $message = $deleted->getMessage());
        $this->assertSame($this->id, $message->userId);
    }
}

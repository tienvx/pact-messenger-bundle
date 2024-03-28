<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Messenger\Envelope;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserCreated;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserDeleted;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserUpdated;

class UserControllerTest extends WebTestCase
{
    public function testCreateUser(): void
    {
        $client = static::createClient();
        $client->request('POST', '/create');
        $this->assertResponseIsSuccessful();

        $container = static::getContainer();
        $collector = $container->get(EnvelopeCollectorInterface::class);
        $this->assertCount(1, $all = $collector->getAll());

        $this->assertInstanceOf(Envelope::class, $created = $collector->getSingle(UserCreated::class));
        $this->assertTrue(in_array($created, $all));
        $this->assertInstanceOf(UserCreated::class, $message = $created->getMessage());
        $this->assertSame(123, $message->userId);
    }

    public function testUpdateUser(): void
    {
        $client = static::createClient();
        $client->request('PUT', '/update/123');
        $this->assertResponseIsSuccessful();

        $container = static::getContainer();
        $collector = $container->get(EnvelopeCollectorInterface::class);
        $this->assertCount(1, $all = $collector->getAll());

        $this->assertInstanceOf(Envelope::class, $created = $collector->getSingle(UserUpdated::class));
        $this->assertTrue(in_array($created, $all));
        $this->assertInstanceOf(UserUpdated::class, $message = $created->getMessage());
        $this->assertSame(123, $message->userId);
    }

    public function testDeleteUser(): void
    {
        $client = static::createClient();
        $client->request('DELETE', '/delete/123');
        $this->assertResponseIsSuccessful();

        $container = static::getContainer();
        $collector = $container->get(EnvelopeCollectorInterface::class);
        $this->assertCount(1, $all = $collector->getAll());

        $this->assertInstanceOf(Envelope::class, $created = $collector->getSingle(UserDeleted::class));
        $this->assertTrue(in_array($created, $all));
        $this->assertInstanceOf(UserDeleted::class, $message = $created->getMessage());
        $this->assertSame(123, $message->userId);
    }
}

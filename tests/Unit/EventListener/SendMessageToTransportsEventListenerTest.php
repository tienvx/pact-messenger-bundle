<?php

namespace Tienvx\Bundle\PactProviderBundle\Tests\Unit\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Event\SendMessageToTransportsEvent;
use Tienvx\Bundle\PactMessengerBundle\EventListener\SendMessageToTransportsEventListener;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserCreated;

class SendMessageToTransportsEventListenerTest extends TestCase
{
    private SendMessageToTransportsEventListener $listener;
    protected EnvelopeCollectorInterface|MockObject $collector;

    protected function setUp(): void
    {
        $this->collector = $this->createMock(EnvelopeCollectorInterface::class);
        $this->listener = new SendMessageToTransportsEventListener($this->collector);
    }

    public function testCollect(): void
    {
        $event = new SendMessageToTransportsEvent($envelop = new Envelope(new UserCreated(123)), ['async']);
        $this->collector
            ->expects($this->once())
            ->method('collect')
            ->with($envelop);
        call_user_func($this->listener, $event);
    }
}

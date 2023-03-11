<?php

namespace Tienvx\Bundle\PactMessengerBundle\Service;

use Symfony\Component\Messenger\Envelope;

interface EnvelopeCollectorInterface
{
    public function collect(Envelope $envelope): void;

    public function getAll(): array;

    public function getSingle(string $messageFqcn): ?Envelope;
}

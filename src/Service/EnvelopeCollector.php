<?php

namespace Tienvx\Bundle\PactMessengerBundle\Service;

use Symfony\Component\Messenger\Envelope;

class EnvelopeCollector implements EnvelopeCollectorInterface
{
    /** @var array<int, Envelope> */
    private array $envelopes;

    public function collect(Envelope $envelope): void
    {
        $this->envelopes[] = $envelope;
    }

    public function getAll(): array
    {
        return $this->envelopes;
    }

    public function getSingle(string $messageFqcn): ?Envelope
    {
        foreach ($this->envelopes as $envelope) {
            if ($envelope->getMessage() instanceof $messageFqcn) {
                return $envelope;
            }
        }

        return null;
    }
}

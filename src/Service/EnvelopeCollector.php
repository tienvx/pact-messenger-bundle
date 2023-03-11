<?php

namespace Tienvx\Bundle\PactMessengerBundle\Service;

use Symfony\Component\Messenger\Envelope;
use Tienvx\Bundle\PactMessengerBundle\Exception\LogicException;

class EnvelopeCollector implements EnvelopeCollectorInterface
{
    /** @var array<int, Envelope> */
    private array $envelopes;

    /** @var array<int, string[]|null> */
    private array $transportsByEnvelope;

    public function collect(Envelope $envelope, ?array $transports = null): void
    {
        $this->envelopes[] = $envelope;
        $this->transportsByEnvelope[spl_object_id($envelope)] = $transports;
    }

    public function getAll(): array
    {
        return $this->envelopes;
    }

    public function getSingle(string $messageFqcn, ?string $transport = null): ?Envelope
    {
        foreach ($this->envelopes as $envelope) {
            if (!$envelope->getMessage() instanceof $messageFqcn) {
                continue;
            }
            if (is_null($transport)) {
                return $envelope;
            }
            $transports = $this->transportsByEnvelope[spl_object_id($envelope)];
            if (is_null($transports)) {
                throw new LogicException('You need to upgrade to Symfony >=6.2 to be able to filter envelope by transport.');
            }
            if (in_array($transport, $transports)) {
                return $envelope;
            }
        }

        return null;
    }
}

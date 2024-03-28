<?php

namespace Tienvx\Bundle\MbtBundle\Tests\Unit\DependencyInjection;

use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Tienvx\Bundle\PactMessengerBundle\DependencyInjection\TienvxPactMessengerExtension;
use Tienvx\Bundle\PactMessengerBundle\EventListener\SendMessageToTransportsEventListener;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollector;
use Tienvx\Bundle\PactMessengerBundle\Service\EnvelopeCollectorInterface;

class TienvxPactMessengerExtensionTest extends TestCase
{
    protected ContainerBuilder $container;
    protected TienvxPactMessengerExtension $loader;

    protected function setUp(): void
    {
        $this->container = new ContainerBuilder();
        $this->loader = new TienvxPactMessengerExtension();
    }

    public function testLoad(): void
    {
        $this->loader->load([], $this->container);
        $services = [
            EnvelopeCollector::class => [
                'alias' => EnvelopeCollectorInterface::class,
                'args' => fn (array $args) => [] === $args,
            ],
            SendMessageToTransportsEventListener::class => [
                'tag' => 'kernel.event_listener',
                'args' => fn (array $args) => 1 === count($args)
                    && EnvelopeCollectorInterface::class == $args[0],
            ],
        ];
        foreach ($services as $key => $value) {
            $this->assertTrue($this->container->has($key));
            $definition = $this->container->getDefinition($key);
            if (isset($value['tag'])) {
                $this->assertTrue($definition->hasTag($value['tag']));
            }
            $this->assertTrue($value['args']($definition->getArguments()));
            if (isset($value['alias'])) {
                $this->assertEquals($key, $this->container->getAlias($value['alias']));
            }
        }
    }
}

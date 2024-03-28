<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message;

class UserCreated
{
    public function __construct(public readonly int $userId)
    {
    }
}

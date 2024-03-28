<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message;

class UserCreated
{
    public function __construct(public readonly int $userId)
    {
    }
}

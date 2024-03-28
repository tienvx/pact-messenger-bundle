<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message;

class UserUpdated
{
    public function __construct(public readonly int $userId)
    {
    }
}

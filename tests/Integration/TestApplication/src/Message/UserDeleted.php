<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\Integration\TestApplication\Message;

class UserDeleted
{
    public function __construct(public readonly int $userId)
    {
    }
}

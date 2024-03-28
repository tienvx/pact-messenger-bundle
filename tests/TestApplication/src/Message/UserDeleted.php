<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message;

class UserDeleted
{
    public function __construct(public readonly int $userId)
    {
    }
}

<?php

namespace Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserCreated;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserDeleted;
use Tienvx\Bundle\PactMessengerBundle\Tests\TestApplication\Message\UserUpdated;

class UserController
{
    #[Route('/create', name: 'create_user', methods: Request::METHOD_POST)]
    public function create(MessageBusInterface $bus): Response
    {
        $bus->dispatch(new UserCreated(123));

        return new Response('created');
    }

    #[Route('/update/{id}', name: 'update_user', methods: Request::METHOD_PUT)]
    public function update(int $id, MessageBusInterface $bus): Response
    {
        $bus->dispatch(new UserUpdated($id));

        return new Response('updated');
    }

    #[Route('/delete/{id}', name: 'delete_user', methods: Request::METHOD_DELETE)]
    public function delete(int $id, MessageBusInterface $bus): Response
    {
        $bus->dispatch(new UserDeleted($id));

        return new Response('deleted');
    }
}

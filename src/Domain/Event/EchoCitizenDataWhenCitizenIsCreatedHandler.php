<?php

declare(strict_types=1);

namespace Domain\Event;

class EchoCitizenDataWhenCitizenIsCreatedHandler implements EventHandlerInterface
{
    public function handle(Event $event): void
    {
        $data = $event->eventData;

        echo "Created citizen with id: $data->id, name: $data->name and email: $data->email";
    }
}

<?php

declare(strict_types=1);

namespace Domain\shared\Event;

interface EventHandlerInterface
{
    public function handle(Event $event): void;
}

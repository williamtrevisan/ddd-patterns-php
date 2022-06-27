<?php

declare(strict_types=1);

namespace Domain\shared\Event;

interface EventDispatcherInterface
{
    public function register(
        string $eventName,
        EventHandlerInterface $eventHandler
    ): void;
    public function unregister(
        string $eventName,
        EventHandlerInterface $eventHandler
    ): void;
    public function unregisterAll(): void;
    public function notify(Event $event): void;
}

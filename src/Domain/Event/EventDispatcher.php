<?php

namespace Domain\Event;

class EventDispatcher implements EventDispatcherInterface
{
    private array $eventHandlers = [];

    public function register(
        string $eventName,
        EventHandlerInterface $eventHandler
    ): void {
        if (! array_key_exists($eventName, $this->eventHandlers)) {
            $this->eventHandlers[$eventName] = [];
        }

        $this->eventHandlers[$eventName][] = $eventHandler;
    }

    public function unregister(
        string $eventName,
        EventHandlerInterface $eventHandler
    ): void {
        unset($this->eventHandlers[$eventName]);
    }

    public function unregisterAll(): void
    {
        $this->eventHandlers = [];
    }

    public function notify(Event $event): void
    {
        $eventName = get_class($event);

        if (! array_key_exists($eventName, $this->eventHandlers)) {
            return;
        }

        foreach ($this->eventHandlers[$eventName] as $eventHandler) {
            $eventHandler->handle($event);
        }
    }

    public function eventHandlers(): array
    {
        return $this->eventHandlers;
    }
}

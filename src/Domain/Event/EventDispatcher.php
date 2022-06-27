<?php

declare(strict_types=1);

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
        if (! array_key_exists($eventName, $this->eventHandlers)) {
            return;
        }

        $eventHandlerKey = array_search($eventHandler, $this->eventHandlers[$eventName]);
        if ($eventHandlerKey !== false) {
            unset($this->eventHandlers[$eventName][$eventHandlerKey]);
        }
    }

    public function unregisterAll(): void
    {
        $this->eventHandlers = [];
    }

    public function notify(Event $event): void
    {
        $class = get_class($event);
        $classExploded = explode('\\', $class);
        $eventName = end($classExploded);

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

<?php

namespace Tests\Domain\Event;

use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class EventDispatcherUnitTest extends TestCase
{
    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_register_an_event_handler()
    {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = Mockery::mock(stdClass::class, EventHandlerInterface::class);

        $eventDispatcher->register('CitizenCreatedEvent', $eventHandler);

        $this->assertArrayHasKey(
            'CitizenCreatedEvent',
            $eventDispatcher->eventHandlers()
        );
        $this->assertCount(1, $eventDispatcher->eventHandlers());
    }

    /** @test */
    public function should_be_able_to_unregister_an_event_handler()
    {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = Mockery::mock(stdClass::class, EventHandlerInterface::class);
        $eventDispatcher->register('CitizenCreatedEvent', $eventHandler);

        $eventDispatcher->unregister('CitizenCreatedEvent', $eventHandler);

        $this->assertArrayHasKey(
            'CitizenCreatedEvent',
            $eventDispatcher->eventHandlers()
        );
        $this->assertEmpty($eventDispatcher->eventHandlers()['CitizenCreatedEvent']);
    }

    /** @test */
    public function should_be_able_to_unregister_all_event_handlers()
    {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = Mockery::mock(stdClass::class, EventHandlerInterface::class);
        $eventDispatcher->register('CitizenCreatedEvent', $eventHandler);

        $eventDispatcher->unregisterAll();

        $this->assertArrayNotHasKey(
            'CitizenCreatedEvent',
            $eventDispatcher->eventHandlers()
        );
        $this->assertEmpty($eventDispatcher->eventHandlers());
    }

    /** @test */
    public function should_be_able_to_notify_all_event_handlers()
    {
        $eventDispatcher = new EventDispatcher();
        $event = Mockery::namedMock('CitizenCreatedEvent', Event::class, [
            ['name' => 'Citizen name', 'email' => 'email@citizen.com']
        ]);
        $eventHandler = Mockery::mock(stdClass::class, EventHandlerInterface::class);
        $eventHandler->shouldReceive('handle')->once()->with($event);
        $eventDispatcher->register('CitizenCreatedEvent', $eventHandler);

        $eventDispatcher->notify($event);

        $this->assertInstanceOf(EventHandlerInterface::class, $eventHandler);
    }
}

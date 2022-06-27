<?php

declare(strict_types=1);

namespace Domain\Event;

use Domain\Factory\CitizenFactory;
use PHPUnit\Framework\TestCase;

class EchoCitizenDataWhenCitizenIsCreatedHandlerTest extends TestCase
{
    /** @test */
    public function should_be_able_to_echo_citizen_data_when_citizen_is_created()
    {
        $eventDispatcher = new EventDispatcher();
        $eventHandler = new EchoCitizenDataWhenCitizenIsCreatedHandler();
        $eventDispatcher->register('CitizenCreatedEvent', $eventHandler);
        $citizen = CitizenFactory::create([
            'name' => 'Citizen name',
            'email' => 'email@citizen.com'
        ]);
        $citizenCreatedEvent = new CitizenCreatedEvent($citizen);

        $eventDispatcher->notify($citizenCreatedEvent);

        $this->expectOutputString(
            "Created citizen with id: $citizen->id, name: $citizen->name and email: $citizen->email"
        );
    }
}

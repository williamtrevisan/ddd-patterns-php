<?php

declare(strict_types=1);

namespace Tests\Citizen\Domain\Factory;

use Domain\Citizen\Factory\CitizenFactory;
use PHPUnit\Framework\TestCase;

class CitizenFactoryUnitTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_a_new_citizen()
    {
        $payload = ['name' => 'Citizen name', 'email' => 'email@email.com'];

        $citizen = CitizenFactory::create($payload);

        $this->assertNotEmpty($citizen->id);
        $this->assertEquals($payload['name'], $citizen->name);
        $this->assertEquals($payload['email'], $citizen->email);
    }
}

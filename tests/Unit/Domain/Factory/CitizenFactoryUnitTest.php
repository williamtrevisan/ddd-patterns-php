<?php

namespace Tests\Unit\Domain\Factory;

use Domain\Factory\CitizenFactory;
use PHPUnit\Framework\TestCase;

class CitizenFactoryUnitTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_a_new_citizen()
    {
        $payload = ['name' => 'Book title', 'email' => 'email@email.com'];

        $citizen = CitizenFactory::create($payload);

        $this->assertNotEmpty($citizen->id);
        $this->assertEquals($payload['name'], $citizen->name);
        $this->assertEquals($payload['email'], $citizen->email);
    }
}
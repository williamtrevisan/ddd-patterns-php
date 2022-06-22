<?php

namespace Tests\Unit\Domain\Entity;

use Domain\Entity\Citizen;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class CitizenUnitTest extends TestCase
{
    /** @test */
    public function should_be_throw_an_exception_if_name_received_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Ci', 'email' => 'email@citizen.com'];

        new Citizen(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256), 'email' => 'email@citizen.com'];

        new Citizen(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_throw_an_excpetion_if_email_received_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The email must be valid');

        $payload = ['name' => 'Citizen name', 'email' => 'email.com'];

        new Citizen(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_able_to_create_a_new_citizen()
    {
        $payload = ['name' => 'Citizen name', 'email' => 'email@citizen.com'];

        $citizen = new Citizen(name: $payload['name'], email: $payload['email']);

        $this->assertNotEmpty($citizen->id);
        $this->assertEquals($payload['name'], $citizen->name);
        $this->assertEquals($payload['email'], $citizen->email);
    }

    /** @test */
    public function should_be_able_to_create_a_new_citizen_sendind_an_id()
    {
        $payload = [
            'id' => Uuid::uuid4(),
            'name' => 'Citizen name',
            'email' => 'email@citizen.com'
        ];

        $citizen = new Citizen(
            name: $payload['name'],
            email: $payload['email'],
            id: $payload['id']
        );

        $this->assertEquals($payload['id'], $citizen->id);
        $this->assertEquals($payload['name'], $citizen->name);
        $this->assertEquals($payload['email'], $citizen->email);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_method_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Ci'];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256)];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_excpetion_if_email_received_in_update_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The email must be valid');

        $payload = ['email' => 'email.com'];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(email: $payload['email']);
    }

    /** @test */
    public function should_be_able_to_change_citizen_name()
    {
        $payload = ['name' => 'Citizen name updated'];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(name: $payload['name']);

        $this->assertEquals($payload['name'], $citizen->name);
    }

    /** @test */
    public function should_be_able_to_change_citizen_email()
    {
        $payload = ['email' => 'citizen@email.com'];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(email: $payload['email']);

        $this->assertEquals($payload['email'], $citizen->email);
    }

    /** @test */
    public function should_be_able_to_change_citizen_name_and_email()
    {
        $payload = ['name' => 'Citizen name updated', 'email' => 'citizen@email.com'];

        $citizen = new Citizen(name: 'Citizen name', email: 'email@citizen.com');
        $citizen->update(name: $payload['name'], email: $payload['email']);

        $this->assertEquals($payload['name'], $citizen->name);
        $this->assertEquals($payload['email'], $citizen->email);
    }
}
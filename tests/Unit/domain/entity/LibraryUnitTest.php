<?php

namespace Tests\Unit\Domain\Entity;

use Domain\Entity\Library;
use http\Exception\InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class LibraryUnitTest extends TestCase
{
    /** @test */
    public function should_be_throw_an_exception_if_name_received_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Li', 'email' => 'email@library.com'];

        new Library(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256), 'email' => 'email@library.com'];

        new Library(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_throw_an_excpetion_if_email_received_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The email must be valid');

        $payload = ['name' => 'Library name', 'email' => 'email.com'];

        new Library(name: $payload['name'], email: $payload['email']);
    }

    /** @test */
    public function should_be_able_to_create_a_new_library()
    {
        $payload = ['name' => 'Library name', 'email' => 'email@library.com'];

        $library = new Library(name: $payload['name'], email: $payload['email']);

        $this->assertNotEmpty($library->id);
        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }

    /** @test */
    public function should_be_able_to_change_library_name()
    {
        $payload = ['name' => 'Library name updated'];

        $library = new Library(name: 'Library name', email: 'email@library.com');
        $library->update(name: $payload['name']);

        $this->assertEquals($payload['name'], $library->name);
    }

    /** @test */
    public function should_be_able_to_change_library_email()
    {
        $payload = ['email' => 'library@email.com'];

        $library = new Library(name: 'Library name', email: 'email@library.com');
        $library->update(email: $payload['email']);

        $this->assertEquals($payload['email'], $library->email);
    }

    /** @test */
    public function should_be_able_to_change_library_datas()
    {
        $payload = ['name' => 'Library name updated', 'email' => 'library@email.com'];

        $library = new Library(name: 'Library name', email: 'email@library.com');
        $library->update(name: $payload['name'], email: $payload['email']);

        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }
}
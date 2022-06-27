<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use Domain\Entity\Library;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class LibraryUnitTest extends TestCase
{
    /** @test */
    public function should_be_throw_an_exception_if_name_received_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Li',
            'email' => 'email@library.com',
        ];

        new Library(
            id: $payload['id'],
            name: $payload['name'],
            email: $payload['email'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'name' => random_bytes(256),
            'email' => 'email@library.com',
        ];

        new Library(
            id: $payload['id'],
            name: $payload['name'],
            email: $payload['email'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_email_received_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The email must be valid');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Library name',
            'email' => 'email.com',
        ];

        new Library(
            id: $payload['id'],
            name: $payload['name'],
            email: $payload['email'],
        );
    }

    /** @test */
    public function should_be_able_to_create_a_new_library()
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Library name',
            'email' => 'email@library.com',
        ];

        $library = new Library(
            id: $payload['id'],
            name: $payload['name'],
            email: $payload['email'],
        );

        $this->assertNotEmpty($library->id);
        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }

    /** @test */
    public function should_be_able_to_create_a_new_library_sendind_an_id()
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'name' => 'Library name',
            'email' => 'email@library.com',
        ];

        $library = new Library(
            id: $payload['id'],
            name: $payload['name'],
            email: $payload['email'],
        );

        $this->assertEquals($payload['id'], $library->id);
        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_method_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Li'];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256)];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_email_received_in_update_is_invalid()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The email must be valid');

        $payload = ['email' => 'email.com'];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(email: $payload['email']);
    }

    /** @test */
    public function should_be_able_to_change_library_name()
    {
        $payload = ['name' => 'Library name updated'];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(name: $payload['name']);

        $this->assertEquals($payload['name'], $library->name);
    }

    /** @test */
    public function should_be_able_to_change_library_email()
    {
        $payload = ['email' => 'library@email.com'];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(email: $payload['email']);

        $this->assertEquals($payload['email'], $library->email);
    }

    /** @test */
    public function should_be_able_to_change_library_name_and_email()
    {
        $payload = ['name' => 'Library name updated', 'email' => 'library@email.com'];

        $library = new Library(
            id: Uuid::uuid4()->toString(),
            name: 'Library name',
            email: 'email@library.com',
        );
        $library->update(name: $payload['name'], email: $payload['email']);

        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }
}

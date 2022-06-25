<?php

declare(strict_types=1);

namespace Tests\Domain\Entity;

use Domain\Entity\Author;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class AuthorUnitTest extends TestCase
{
    /** @test */
    public function should_be_throw_an_exception_if_name_received_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Ci'];

        new Author(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256)];

        new Author(name: $payload['name']);
    }

    /** @test */
    public function should_be_able_to_create_a_new_author()
    {
        $payload = ['name' => 'Author name'];

        $author = new Author(name: $payload['name']);

        $this->assertNotEmpty($author->id);
        $this->assertEquals($payload['name'], $author->name);
    }

    /** @test */
    public function should_be_able_to_create_a_new_author_sendind_an_id()
    {
        $payload = [
            'id' => Uuid::uuid4(),
            'name' => 'Author name'
        ];

        $author = new Author(
            name: $payload['name'],
            id: $payload['id']
        );

        $this->assertEquals($payload['id'], $author->id);
        $this->assertEquals($payload['name'], $author->name);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_method_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The name must be at least 3 characters');

        $payload = ['name' => 'Ci'];

        $author = new Author(name: 'Author name');
        $author->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_in_update_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The name must not be greater than 255 characters'
        );

        $payload = ['name' => random_bytes(256)];

        $author = new Author(name: 'Author name');
        $author->update(name: $payload['name']);
    }

    /** @test */
    public function should_be_able_to_change_author_name()
    {
        $payload = ['name' => 'Author name updated'];

        $author = new Author(name: 'Author name');
        $author->update(name: $payload['name']);

        $this->assertEquals($payload['name'], $author->name);
    }
}

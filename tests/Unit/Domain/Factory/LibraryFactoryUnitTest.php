<?php

declare(strict_types=1);

namespace Tests\Domain\Factory;

use Domain\Factory\LibraryFactory;
use PHPUnit\Framework\TestCase;

class LibraryFactoryUnitTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_a_new_citizen()
    {
        $payload = ['name' => 'Library name', 'email' => 'email@email.com'];

        $library = LibraryFactory::create($payload);

        $this->assertNotEmpty($library->id);
        $this->assertEquals($payload['name'], $library->name);
        $this->assertEquals($payload['email'], $library->email);
    }
}

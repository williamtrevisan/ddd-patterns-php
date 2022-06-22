<?php

namespace Tests\Unit\Domain\Factory;

use Domain\Factory\BookFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BookFactoryUnitTest extends TestCase
{
    /** @test */
    public function should_be_able_to_create_a_new_book()
    {
        $payload = [
            'libraryId' => Uuid::uuid4(),
            'title' => 'Book title',
            'pageNumber' => 200,
            'yearLaunched' => 2001
        ];

        $book = BookFactory::create($payload);

        $this->assertNotEmpty($book->id);
        $this->assertEquals($payload['libraryId'], $book->libraryId);
        $this->assertEquals($payload['title'], $book->title);
        $this->assertEquals($payload['pageNumber'], $book->pageNumber);
        $this->assertEquals($payload['yearLaunched'], $book->yearLaunched);
    }
}
<?php

namespace Tests\Domain\Entity;

use Domain\Entity\Book;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BookUnitTest extends TestCase
{
    /** @test */
    public function should_be_throw_an_exception_if_library_id_received_is_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The library id is required');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => null,
            'title' => 'Book title',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ];

        new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The title must be at least 3 characters');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Bo',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ];

        new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The title must not be greater than 255 characters'
        );

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => random_bytes(256),
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ];

        new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_page_number_received_is_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The page number is required');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Book title',
            'pageNumber' => null,
            'yearLaunched' => 2001,
        ];

        new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }

    /** @test */
    public function should_be_throw_an_exception_if_year_launched_received_is_null()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The year launched is required');

        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Book title',
            'pageNumber' => 196,
            'yearLaunched' => null,
        ];

        new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }

    /** @test */
    public function should_be_able_to_create_a_new_book()
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Book title',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ];

        $book = new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );

        $this->assertNotEmpty($book->id);
        $this->assertEquals($payload['libraryId'], $book->libraryId);
        $this->assertEquals($payload['title'], $book->title);
        $this->assertEquals($payload['pageNumber'], $book->pageNumber);
        $this->assertEquals($payload['yearLaunched'], $book->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_create_a_new_book_sending_an_id()
    {
        $payload = [
            'id' => Uuid::uuid4()->toString(),
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Book title',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ];

        $book = new Book(
            id: $payload['id'],
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );

        $this->assertEquals($payload['id'], $book->id);
        $this->assertEquals($payload['libraryId'], $book->libraryId);
        $this->assertEquals($payload['title'], $book->title);
        $this->assertEquals($payload['pageNumber'], $book->pageNumber);
        $this->assertEquals($payload['yearLaunched'], $book->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_add_an_author_to_book()
    {
        $authorId = Uuid::uuid4()->toString();
        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );

        $book->addAuthor(authorId: $authorId);

        $this->assertCount(1, $book->authorsId);
        $this->assertEquals([$authorId], $book->authorsId);
    }

    /** @test */
    public function should_be_able_to_add_more_than_once_authors_to_book()
    {
        $authorId1 = Uuid::uuid4()->toString();
        $authorId2 = Uuid::uuid4()->toString();
        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );

        $book->addAuthor(authorId: $authorId1);
        $book->addAuthor(authorId: $authorId2);

        $this->assertCount(2, $book->authorsId);
        $this->assertEquals([$authorId1, $authorId2], $book->authorsId);
    }

    /** @test */
    public function should_be_able_to_remove_an_author_to_book()
    {
        $authorId = Uuid::uuid4()->toString();
        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->addAuthor(authorId: $authorId);

        $book->removeAuthor(authorId: $authorId);

        $this->assertCount(0, $book->authorsId);
        $this->assertEquals([], $book->authorsId);
    }

    /** @test */
    public function should_be_able_to_update_a_book_library_id()
    {
        $payload = ['libraryId' => Uuid::uuid4()->toString()];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(libraryId: $payload['libraryId']);

        $this->assertEquals($payload['libraryId'], $book->libraryId);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_to_update_dont_has_at_least_3_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('The title must be at least 3 characters');

        $payload = ['title' => 'Bo'];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(title: $payload['title']);
    }

    /** @test */
    public function should_be_throw_an_exception_if_name_received_to_update_is_greater_than_255_characters()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            'The title must not be greater than 255 characters'
        );

        $payload = ['title' => random_bytes(256)];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(title: $payload['title']);
    }

    /** @test */
    public function should_be_able_to_update_a_book_title()
    {
        $payload = ['title' => 'Book title updated'];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(title: $payload['title']);

        $this->assertEquals($payload['title'], $book->title);
    }

    /** @test */
    public function should_be_able_to_update_a_book_page_number()
    {
        $payload = ['pageNumber' => 251];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(pageNumber: $payload['pageNumber']);

        $this->assertEquals($payload['pageNumber'], $book->pageNumber);
    }

    /** @test */
    public function should_be_able_to_update_a_book_year_launched()
    {
        $payload = ['yearLaunched' => 2010];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(yearLaunched: $payload['yearLaunched']);

        $this->assertEquals($payload['yearLaunched'], $book->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_update_all_book_data()
    {
        $payload = [
            'libraryId' => Uuid::uuid4()->toString(),
            'title' => 'Book title updated',
            'pageNumber' => 251,
            'yearLaunched' => 2010
        ];

        $book = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book->update(
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );

        $this->assertEquals($payload['libraryId'], $book->libraryId);
        $this->assertEquals($payload['title'], $book->title);
        $this->assertEquals($payload['pageNumber'], $book->pageNumber);
        $this->assertEquals($payload['yearLaunched'], $book->yearLaunched);
    }
}

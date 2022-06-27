<?php

declare(strict_types=1);

namespace Tests\Domain\Service;

use Domain\Entity\Book;
use Domain\Service\BookService;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BookServiceUnitTest extends TestCase
{
    /** @test */
    public function should_be_able_to_change_library_id_of_all_books()
    {
        $libraryId = Uuid::uuid4()->toString();
        $book1 = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book1 title',
            pageNumber: 201,
            yearLaunched: 2009,
        );
        $book2 = new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: Uuid::uuid4()->toString(),
            title: 'Book2 title',
            pageNumber: 201,
            yearLaunched: 2009,
        );

        BookService::changeLibraryId([$book1, $book2], $libraryId);

        $this->assertEquals($libraryId, $book1->libraryId);
        $this->assertEquals($libraryId, $book2->libraryId);
    }
}

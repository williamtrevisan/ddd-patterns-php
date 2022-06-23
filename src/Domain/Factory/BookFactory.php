<?php

namespace Domain\Factory;

use Domain\Entity\Book;
use Ramsey\Uuid\Uuid;

class BookFactory
{
    public static function create(array $payload): Book
    {
        return new Book(
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
            id: Uuid::uuid4()
        );
    }
}

<?php

declare(strict_types=1);

namespace Domain\Factory;

use Domain\Entity\Book;
use Ramsey\Uuid\Uuid;

class BookFactory
{
    public static function create(array $payload): Book
    {
        return new Book(
            id: Uuid::uuid4()->toString(),
            libraryId: $payload['libraryId'],
            title: $payload['title'],
            pageNumber: $payload['pageNumber'],
            yearLaunched: $payload['yearLaunched'],
        );
    }
}

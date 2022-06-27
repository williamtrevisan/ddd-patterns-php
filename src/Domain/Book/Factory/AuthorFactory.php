<?php

declare(strict_types=1);

namespace Domain\Book\Factory;

use Domain\Book\Entity\Author;
use Ramsey\Uuid\Uuid;

class AuthorFactory
{
    public static function create(array $payload): Author
    {
        return new Author(
            id: Uuid::uuid4()->toString(),
            name: $payload['name'],
        );
    }
}

<?php

namespace Domain\Factory;

use Domain\Entity\Author;
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

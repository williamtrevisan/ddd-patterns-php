<?php

namespace Domain\Factory;

use Domain\Entity\Library;
use Ramsey\Uuid\Uuid;

class LibraryFactory
{
    public static function create(array $payload): Library
    {
        return new Library(
            name: $payload['name'],
            email: $payload['email'],
            id: Uuid::uuid4()
        );
    }
}

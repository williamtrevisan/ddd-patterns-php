<?php

declare(strict_types=1);

namespace Domain\Library\Factory;

use Domain\Library\Entity\Library;
use Ramsey\Uuid\Uuid;

class LibraryFactory
{
    public static function create(array $payload): Library
    {
        return new Library(
            id: Uuid::uuid4()->toString(),
            name: $payload['name'],
            email: $payload['email'],
        );
    }
}

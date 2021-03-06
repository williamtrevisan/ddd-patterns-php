<?php

declare(strict_types=1);

namespace Domain\Citizen\Factory;

use Domain\Citizen\Entity\Citizen;
use Ramsey\Uuid\Uuid;

class CitizenFactory
{
    public static function create(array $payload): Citizen
    {
        return new Citizen(
            id: Uuid::uuid4()->toString(),
            name: $payload['name'],
            email: $payload['email'],
        );
    }
}

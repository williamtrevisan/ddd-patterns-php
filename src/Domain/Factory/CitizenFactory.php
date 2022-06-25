<?php

namespace Domain\Factory;

use Domain\Entity\Citizen;
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

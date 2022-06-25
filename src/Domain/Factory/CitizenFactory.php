<?php

namespace Domain\Factory;

use Domain\Entity\Citizen;
use Ramsey\Uuid\Uuid;

class CitizenFactory
{
    public static function create(array $payload): Citizen
    {
        return new Citizen(
            name: $payload['name'],
            email: $payload['email'],
            id: Uuid::uuid4()
        );
    }
}

<?php

namespace Domain\Entity;

use Ramsey\Uuid\UuidInterface;

abstract class Entity
{
    protected ?UuidInterface $id;

    public function __get(string $property)
    {
        return $this->{$property};
    }
}
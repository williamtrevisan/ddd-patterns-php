<?php

declare(strict_types=1);

namespace Domain\Entity;

abstract class Entity
{
    protected string $id;

    public function __get(string $property)
    {
        return $this->{$property};
    }
}

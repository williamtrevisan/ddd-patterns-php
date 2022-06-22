<?php

namespace Infrastructure\Repository;

use Domain\Entity\Entity;
use Domain\Repository\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface
{
    public function create(Entity $entity): Entity
    {
        // TODO: Implement create() method.
    }

    public function findByPk(string $id): Entity
    {
        // TODO: Implement findByPk() method.
    }

    public function findAll(): array
    {
        // TODO: Implement findAll() method.
    }

    public function update(Entity $entity): Entity
    {
        // TODO: Implement update() method.
    }
}
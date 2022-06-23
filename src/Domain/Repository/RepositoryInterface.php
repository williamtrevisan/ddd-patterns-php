<?php

namespace Domain\Repository;

use Domain\Entity\Entity;

interface RepositoryInterface
{
    public function create(Entity $entity): void;
    public function findByPk(string $id): Entity;
    public function findAll(): array;
    public function update(Entity $entity): void;
}
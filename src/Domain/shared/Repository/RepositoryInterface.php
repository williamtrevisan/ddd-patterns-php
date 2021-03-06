<?php

declare(strict_types=1);

namespace Domain\shared\Repository;

use Domain\shared\Entity\Entity;

interface RepositoryInterface
{
    public function create(Entity $entity): void;
    public function findByPk(string $id): Entity;
    public function findAll(): array;
    public function update(Entity $entity): void;
}

<?php

declare(strict_types=1);

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Entity\Author;
use Domain\Entity\Entity;
use Domain\Repository\AuthorRepositoryInterface;
use Exception;
use Infrastructure\Entity\Author as InfrastructureAuthor;

class AuthorRepository extends EntityRepository implements AuthorRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $this->getEntityManager()->persist($this->toInfrastructureEntity($entity));
        $this->getEntityManager()->flush();
    }

    public function findByPk(string $id): Entity
    {
        $author = $this->find($id);
        if (! $author) {
            throw new Exception("Author with id: $id not found");
        }

        return $this->toDomainEntity($author);
    }

    public function findAll(): array
    {
        $authors = parent::findAll();

        return array_map(fn ($author) => $this->toDomainEntity($author), $authors);
    }

    public function update(Entity $entity): void
    {
        $author = $this->find($entity->id);
        if (! $author) {
            throw new Exception("Author with id: $entity->id not found");
        }

        $author->setName($entity->name);

        $this->getEntityManager()->flush();
    }

    private function toDomainEntity(object $object): Entity
    {
        return new Author(
            id: $object->id,
            name: $object->name,
        );
    }

    private function toInfrastructureEntity(Entity $entity): InfrastructureAuthor
    {
        return new InfrastructureAuthor(
            id: $entity->id,
            name: $entity->name,
        );
    }
}

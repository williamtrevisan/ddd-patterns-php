<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Entity\Library;
use Domain\Entity\Entity;
use Domain\Repository\LibraryRepositoryInterface;
use Exception;
use Infrastructure\Entity\Library as InfrastructureLibrary;

class LibraryRepository extends EntityRepository implements LibraryRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $this->getEntityManager()->persist($this->toInfrastructureEntity($entity));
        $this->getEntityManager()->flush();
    }

    public function findByPk(string $id): Entity
    {
        $library = $this->find($id);
        if (! $library) {
            throw new Exception("Library with id: $id not found");
        }

        return $this->toDomainEntity($library);
    }

    public function findAll(): array
    {
        $libraries = parent::findAll();

        return array_map(fn ($library) => $this->toDomainEntity($library), $libraries);
    }

    public function update(Entity $entity): void
    {
        $library = $this->find($entity->id);
        if (! $library) {
            throw new Exception("Book with id: $entity->id not found");
        }

        $library->setName($entity->name);
        $library->setEmail($entity->email);

        $this->getEntityManager()->flush();
    }

    private function toDomainEntity(object $object): Entity
    {
        return new Library(
            id: $object->id,
            name: $object->name,
            email: $object->email,
        );
    }

    private function toInfrastructureEntity(Entity $entity): InfrastructureLibrary
    {
        return new InfrastructureLibrary(
            id: $entity->id,
            name: $entity->name,
            email: $entity->email,
        );
    }
}

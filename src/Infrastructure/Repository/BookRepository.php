<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Entity\Book;
use Domain\Entity\Entity;
use Domain\Factory\BookFactory;
use Domain\Repository\BookRepositoryInterface;
use Exception;

class BookRepository extends EntityRepository implements BookRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $this->getEntityManager()->persist($this->toInfrastructureEntity($entity));
        $this->getEntityManager()->flush();
    }

    public function findByPk(string $id): Entity
    {
        $book = $this->findOneBy(['id' => $id]);
        if (! $book) throw new Exception("Book with id: $id not found");

        return $this->toEntity($book);
    }

    public function findAll(): array
    {
        $books = $this->findAll();

        return array_map(fn($book) => $this->toDomainEntity($book), $books);
    }

    public function update(Entity $entity): void
    {
        $book = $this->findOneBy(['id' => $entity->id]);
        if (! $book) throw new Exception("Book with id: $entity->id not found");

        $this->getEntityManager()->flush();
    }

    private function toDomainEntity(object $object): Entity
    {
        return new Book(
            libraryId: $object->libraryId,
            title: $object->title,
            pageNumber: $object->pageNumber,
            yearLaunched: $object->yearLaunched,
            id: $object->id,
        );
    }

    private function toInfrastructureEntity(Entity $entity): \Infrastructure\Entity\Book
    {
        return new \Infrastructure\Entity\Book(
            id: $entity->id,
            libraryId: $entity->libraryId,
            title: $entity->title,
            pageNumber: $entity->pageNumber,
            yearLaunched: $entity->yearLaunched,
        );
    }
}
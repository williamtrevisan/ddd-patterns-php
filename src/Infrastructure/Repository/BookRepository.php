<?php

namespace Infrastructure\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Entity\Book;
use Domain\Entity\Entity;
use Domain\Repository\BookRepositoryInterface;
use Exception;
use Infrastructure\Entity\Book as InfrastructureBook;

class BookRepository extends EntityRepository implements BookRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $this->getEntityManager()->persist($this->toInfrastructureEntity($entity));
        $this->getEntityManager()->flush();
    }

    public function findByPk(string $id): Entity
    {
        $book = $this->find($id);
        if (! $book) {
            throw new Exception("Book with id: $id not found");
        }

        return $this->toDomainEntity($book);
    }

    public function findAll(): array
    {
        $books = parent::findAll();

        return array_map(fn ($book) => $this->toDomainEntity($book), $books);
    }

    public function update(Entity $entity): void
    {
        $book = $this->find($entity->id);
        if (! $book) {
            throw new Exception("Book with id: $entity->id not found");
        }

        $book->setLibraryId($entity->libraryId);
        $book->setTitle($entity->title);
        $book->setPageNumber($entity->pageNumber);
        $book->setYearLaunched($entity->yearLaunched);

        $this->getEntityManager()->flush();
    }

    private function toDomainEntity(object $object): Entity
    {
        return new Book(
            id: $object->id,
            libraryId: $object->libraryId,
            title: $object->title,
            pageNumber: $object->pageNumber,
            yearLaunched: $object->yearLaunched,
        );
    }

    private function toInfrastructureEntity(Entity $entity): InfrastructureBook
    {
        return new InfrastructureBook(
            id: $entity->id,
            libraryId: $entity->libraryId,
            title: $entity->title,
            pageNumber: $entity->pageNumber,
            yearLaunched: $entity->yearLaunched,
        );
    }
}

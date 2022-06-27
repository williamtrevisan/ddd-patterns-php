<?php

declare(strict_types=1);

namespace Infrastructure\Book\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Book\Entity\Book as DomainBook;
use Domain\Book\Repository\BookRepositoryInterface;
use Domain\shared\Entity\Entity;
use Exception;
use Infrastructure\Book\Doctrine\Entity\Author as InfrastructureAuthor;
use Infrastructure\Book\Doctrine\Entity\Book as InfrastructureBook;

class BookRepository extends EntityRepository implements BookRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $book = $this->toInfrastructureEntity($entity);

        if ($entity->authorsId) {
            $this->joinAuthors($entity, $book);
        }

        $this->getEntityManager()->persist($book);
        $this->getEntityManager()->flush();
    }

    private function joinAuthors(Entity $entity, InfrastructureBook $book): void
    {
        foreach ($entity->authorsId as $authorId) {
            $authorRepository = $this->getEntityManager()->getRepository(InfrastructureAuthor::class);
            $author = $authorRepository->find($authorId);

            $book->joinAuthors($author);
        }
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
        return new DomainBook(
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

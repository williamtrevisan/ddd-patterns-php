<?php

namespace Infrastructure\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Repository\BookRepository;
use Ramsey\Uuid\UuidInterface;

#[Entity(repositoryClass: BookRepository::class)]
#[Table(name: 'books')]
class Book
{
    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        public UuidInterface $id,
        #[Column(name: 'id_library', type: Types::GUID)]
        public UuidInterface $libraryId,
        #[Column(type: 'string')]
        public string $title,
        #[Column(name: 'page_number', type: Types::INTEGER)]
        public int $pageNumber,
        #[Column(name: 'year_launched', type: Types::INTEGER)]
        public int $yearLaunched,
    ) {
    }

    public function setLibraryId(UuidInterface $libraryId): void
    {
        $this->libraryId = $libraryId;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function setPageNumber(int $pageNumber): void
    {
        $this->pageNumber = $pageNumber;
    }

    public function setYearLaunched(int $yearLaunched): void
    {
        $this->yearLaunched = $yearLaunched;
    }
}

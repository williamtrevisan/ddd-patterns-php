<?php

namespace Infrastructure\Entity;

use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Ramsey\Uuid\UuidInterface;

#[Entity(repositoryClass: 'BookRepository')]
#[Table(name: 'books')]
class Book
{
    public function __construct(
        #[Id]
        #[Column(type: 'uuid')]
        public UuidInterface $id,

        #[Column(name: 'id_library', type: 'uuid')]
        public UuidInterface $libraryId,

        #[Column(type: 'string')]
        public string $title,

        #[Column(name: 'page_number', type: 'integer')]
        public int $pageNumber,

        #[Column(name: 'year_launched', type: 'integer')]
        public int $yearLaunched,
    ) {}
}
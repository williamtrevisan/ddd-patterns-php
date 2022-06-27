<?php

declare(strict_types=1);

namespace Infrastructure\Book\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Book\Doctrine\Repository\BookRepository;

#[Entity(repositoryClass: BookRepository::class)]
#[Table(name: 'books')]
class Book
{
    #[ManyToMany(targetEntity: Author::class, inversedBy: 'author')]
    #[JoinTable(name: 'books_authors')]
    public Collection $authors;

    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        public string $id,
        #[Column(name: 'id_library', type: Types::GUID)]
        public string $libraryId,
        #[Column(type: 'string')]
        public string $title,
        #[Column(name: 'page_number', type: Types::INTEGER)]
        public int $pageNumber,
        #[Column(name: 'year_launched', type: Types::INTEGER)]
        public int $yearLaunched,
    ) {
        $this->authors = new ArrayCollection();
    }

    public function authors(): array
    {
        return $this->authors->toArray();
    }

    public function joinAuthors(Author $author): void
    {
        $author->addBooks($this);

        $this->authors->add($author);
    }

    public function setLibraryId(string $libraryId): void
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

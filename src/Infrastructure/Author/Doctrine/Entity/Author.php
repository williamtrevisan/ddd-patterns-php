<?php

declare(strict_types=1);

namespace Infrastructure\Author\Doctrine\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Author\Doctrine\Repository\AuthorRepository;
use Infrastructure\Book\Doctrine\Entity\Book;

#[Entity(repositoryClass: AuthorRepository::class)]
#[Table(name: 'authors')]
class Author
{
    #[ManyToMany(targetEntity: Book::class, mappedBy: 'author')]
    private Collection $books;

    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        private string $id,
        #[Column(type: 'string')]
        private string $name,
    ) {
        $this->books = new ArrayCollection();
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getBooks(): ArrayCollection
    {
        return $this->books;
    }

    public function addBooks(Book $book): void
    {
        $this->books->add($book);
    }
}

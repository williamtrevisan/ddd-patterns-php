<?php

namespace Infrastructure\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Repository\AuthorRepository;

#[Entity(repositoryClass: AuthorRepository::class)]
#[Table(name: 'authors')]
class Author
{
    #[ManyToMany(targetEntity: Book::class, mappedBy: 'author')]
    public Collection $books;

    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        public string $id,
        #[Column(type: 'string')]
        public string $name,
    ) {
        $this->books = new ArrayCollection();
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function books(): ArrayCollection
    {
        return $this->books;
    }

    public function addBooks(Book $book): void
    {
        $this->books->add($book);
    }
}

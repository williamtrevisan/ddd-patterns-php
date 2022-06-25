<?php

namespace Infrastructure\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Repository\AuthorRepository;

#[Entity(repositoryClass: AuthorRepository::class)]
#[Table(name: 'authors')]
class Author
{
    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        public string $id,
        #[Column(type: 'string')]
        public string $name,
    ) {
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
}

<?php

declare(strict_types=1);

namespace Infrastructure\Library\Doctrine\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Library\Doctrine\Repository\LibraryRepository;

#[Entity(repositoryClass: LibraryRepository::class)]
#[Table(name: 'libraries')]
class Library
{
    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        private string $id,
        #[Column(type: 'string')]
        private string $name,
        #[Column(type: 'string')]
        private string $email,
    ) {
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

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

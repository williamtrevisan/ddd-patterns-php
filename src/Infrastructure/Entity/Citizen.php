<?php

declare(strict_types=1);

namespace Infrastructure\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Infrastructure\Repository\CitizenRepository;

#[Entity(repositoryClass: CitizenRepository::class)]
#[Table(name: 'citizens')]
class Citizen
{
    public function __construct(
        #[Id]
        #[Column(type: Types::GUID)]
        public string $id,
        #[Column(type: 'string')]
        public string $name,
        #[Column(type: 'string')]
        public string $email,
    ) {
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
}

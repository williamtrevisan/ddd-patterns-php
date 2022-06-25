<?php

declare(strict_types=1);

namespace Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Author extends Entity
{
    public function __construct(
        protected string $name,
        ?UuidInterface $id = null,
    ) {
        $this->id = $id ?? Uuid::uuid4();

        $this->validate();
    }

    public function changeName(string $name): void
    {
        $this->name = $name;

        $this->validate();
    }

    private function validate(): void
    {
        if (strlen($this->name) < 3) {
            throw new InvalidArgumentException('The name must be at least 3 characters');
        }

        if (strlen($this->name) > 255) {
            throw new InvalidArgumentException(
                'The name must not be greater than 255 characters'
            );
        }
    }
}

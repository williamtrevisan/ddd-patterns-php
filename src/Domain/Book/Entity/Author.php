<?php

declare(strict_types=1);

namespace Domain\Book\Entity;

use Domain\shared\Entity\Entity;
use InvalidArgumentException;

class Author extends Entity
{
    public function __construct(
        string $id,
        protected string $name,
    ) {
        $this->id = $id;

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

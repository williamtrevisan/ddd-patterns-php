<?php

declare(strict_types=1);

namespace Domain\Library\Entity;

use Domain\shared\Entity\Entity;
use InvalidArgumentException;

class Library extends Entity
{
    public function __construct(
        string $id,
        protected string $name,
        protected string $email,
    ) {
        $this->id = $id;

        $this->validate();
    }

    public function update(string $name = '', string $email = ''): void
    {
        $this->name = $name ?: $this->name;
        $this->email = $email ?: $this->email;

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

        if (! str_contains($this->email, '@')) {
            throw new InvalidArgumentException('The email must be valid');
        }
    }
}

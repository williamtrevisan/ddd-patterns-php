<?php

declare(strict_types=1);

namespace Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Library
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected ?UuidInterface $id = null,
    ) {
        $this->id = $id ?? Uuid::uuid4();

        $this->validate();
    }

    public function __get(string $property)
    {
        return $this->{$property};
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

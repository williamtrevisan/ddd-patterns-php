<?php

declare(strict_types=1);

namespace Domain\Entity;

class Library
{
    public function __construct(
        protected string $name,
        protected string $email,
        protected ?string $id = null,
    ) {}
}
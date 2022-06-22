<?php

declare(strict_types=1);

class Library
{
    public function __construct(
        protected string $id,
        protected string $name,
        protected string $email,
    ) {}
}
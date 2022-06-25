<?php

declare(strict_types=1);

namespace Domain\Entity;

use InvalidArgumentException;

class Book extends Entity
{
    protected array $authorsId;

    public function __construct(
        string $id,
        protected ?string $libraryId,
        protected string $title,
        protected ?int $pageNumber,
        protected ?int $yearLaunched,
    ) {
        $this->id = $id;

        $this->validate();
    }

    public function update(
        ?string $libraryId = null,
        string $title = '',
        ?int $pageNumber = null,
        ?int $yearLaunched = null
    ): void {
        $this->libraryId = $libraryId ?? $this->libraryId;
        $this->title = $title ?: $this->title;
        $this->pageNumber = $pageNumber ?? $this->pageNumber;
        $this->yearLaunched = $yearLaunched ?? $this->yearLaunched;

        $this->validate();
    }

    public function addAuthor(string $authorId): void
    {
        $this->authorsId[] = $authorId;
    }

    public function removeAuthor(string $authorId): void
    {
        $authorIdKey = array_search($authorId, $this->authorsId);

        unset($this->authorsId[$authorIdKey]);
    }

    private function validate(): void
    {
        if (! $this->libraryId) {
            throw new InvalidArgumentException('The library id is required');
        }

        if (strlen($this->title) < 3) {
            throw new InvalidArgumentException('The title must be at least 3 characters');
        }

        if (strlen($this->title) > 255) {
            throw new InvalidArgumentException(
                'The title must not be greater than 255 characters'
            );
        }

        if (! $this->pageNumber) {
            throw new InvalidArgumentException('The page number is required');
        }

        if (! $this->yearLaunched) {
            throw new InvalidArgumentException('The year launched is required');
        }
    }
}

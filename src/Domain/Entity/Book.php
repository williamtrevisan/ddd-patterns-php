<?php

declare(strict_types=1);

namespace Domain\Entity;

use InvalidArgumentException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class Book extends Entity
{
    protected array $authorsId;

    public function __construct(
        protected ?UuidInterface $libraryId,
        protected string $title,
        protected ?int $pageNumber,
        protected ?int $yearLaunched,
        ?UuidInterface $id = null,
    ) {
        $this->id = $id ?? Uuid::uuid4();

        $this->validate();
    }

    public function update(
        ?UuidInterface $libraryId = null,
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

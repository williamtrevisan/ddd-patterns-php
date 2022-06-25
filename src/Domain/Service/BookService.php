<?php

namespace Domain\Service;

use Ramsey\Uuid\UuidInterface;

class BookService
{
    public static function changeLibraryId(
        array $listBooks,
        string $libraryId
    ): array {
        foreach ($listBooks as $book) {
            $book->update(libraryId: $libraryId);
        }

        return $listBooks;
    }
}

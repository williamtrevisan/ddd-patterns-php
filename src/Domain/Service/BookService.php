<?php

namespace Domain\Service;

use Ramsey\Uuid\UuidInterface;

class BookService
{
    public static function changeLibraryId(
        array $listBooks,
        UuidInterface $libraryId
    ): array {
        foreach ($listBooks as $book) {
            $book->update(libraryId: $libraryId);
        }

        return $listBooks;
    }
}

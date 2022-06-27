<?php

declare(strict_types=1);

namespace Domain\Book\Service;

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

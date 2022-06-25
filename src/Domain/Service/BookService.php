<?php

namespace Domain\Service;

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

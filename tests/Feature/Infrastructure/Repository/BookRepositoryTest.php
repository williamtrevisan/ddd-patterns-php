<?php

namespace Tests\Feature\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Domain\Factory\BookFactory;
use Domain\Factory\LibraryFactory;
use Domain\Repository\BookRepositoryInterface;
use Exception;
use Infrastructure\Entity\Book;
use Infrastructure\Repository\BookRepository;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    private EntityManager $entityManager;
    private BookRepositoryInterface $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = ['driver' => 'pdo_sqlite', 'memory' => true];
        $config = ORMSetup::createAttributeMetadataConfiguration(paths: [
            'src/Infrastructure/Doctrine/Entity'
        ], isDevMode: true);

        $this->entityManager = EntityManager::create($connection, $config);
        $this->bookRepository = new BookRepository(
            $this->entityManager,
            $this->entityManager->getClassMetadata(Book::class)
        );
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_book()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $book = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);

        $this->bookRepository->create($book);
        $persistBook = $this->entityManager->find(Book::class, $book->id);

        $this->assertNotEmpty($persistBook->id);
        $this->assertEquals($book->libraryId, $persistBook->libraryId);
        $this->assertEquals($book->title, $persistBook->title);
        $this->assertEquals($book->pageNumber, $persistBook->pageNumber);
        $this->assertEquals($book->yearLaunched, $persistBook->yearLaunched);
    }

    /** @test */
    public function should_be_throw_an_exception_if_cannot_find_a_book()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $book = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Book with id: $book->id not found");

        $this->bookRepository->findByPk($book->id);
    }

    /** @test */
    public function should_be_able_to_find_a_book_by_primary_key()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $book = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $persistBook = $this->bookRepository->findByPk($book->id);

        $this->assertEquals($book->id, $persistBook->id);
        $this->assertEquals($book->libraryId, $persistBook->libraryId);
        $this->assertEquals($book->title, $persistBook->title);
        $this->assertEquals($book->pageNumber, $persistBook->pageNumber);
        $this->assertEquals($book->yearLaunched, $persistBook->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_find_all_books()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $book1 = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book1 name',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ]);
        $book2 = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book2 name',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($book1);
        $this->entityManager->persist($book2);
        $this->entityManager->flush();

        $persistBooks = $this->bookRepository->findAll();

        $this->assertEquals($book1->id, $persistBooks[0]->id);
        $this->assertEquals($book1->libraryId, $persistBooks[0]->libraryId);
        $this->assertEquals($book1->title, $persistBooks[0]->title);
        $this->assertEquals($book1->pageNumber, $persistBooks[0]->pageNumber);
        $this->assertEquals($book1->yearLaunched, $persistBooks[0]->yearLaunched);
        $this->assertEquals($book2->id, $persistBooks[1]->id);
        $this->assertEquals($book2->libraryId, $persistBooks[1]->libraryId);
        $this->assertEquals($book2->title, $persistBooks[1]->title);
        $this->assertEquals($book2->pageNumber, $persistBooks[1]->pageNumber);
        $this->assertEquals($book2->yearLaunched, $persistBooks[1]->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_update_a_book()
    {
        $payload = ['title' => 'Book title updated'];
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $book = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($book);
        $this->entityManager->flush();

        $book->update(title: $payload['title']);
        $this->bookRepository->update($book);
        $persistBook = $this->entityManager->find('Book', $book->id);

        $this->assertEquals($book->id, $persistBook->id);
        $this->assertEquals($book->libraryId, $persistBook->libraryId);
        $this->assertEquals($payload['title'], $persistBook->title);
        $this->assertEquals($book->pageNumber, $persistBook->pageNumber);
        $this->assertEquals($book->yearLaunched, $persistBook->yearLaunched);
    }
}
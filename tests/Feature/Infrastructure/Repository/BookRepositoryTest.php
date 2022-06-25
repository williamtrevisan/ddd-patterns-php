<?php

namespace Tests\Feature\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Domain\Entity\Entity;
use Domain\Factory\BookFactory;
use Domain\Factory\LibraryFactory;
use Exception;
use Infrastructure\Entity\Book;
use PHPUnit\Framework\TestCase;

class BookRepositoryTest extends TestCase
{
    private EntityRepository $bookRepository;
    private EntityManager $entityManager;
    private SchemaTool $schemaTool;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = [
            'driver' => 'pdo_sqlite',
            'path' => ':memory:',
            'memory' => true
        ];
        $config = ORMSetup::createAttributeMetadataConfiguration(paths: [
            'src/Infrastructure/Doctrine/Entity'
        ], isDevMode: true);

        $this->entityManager = EntityManager::create($connection, $config);

        $this->schemaTool = new SchemaTool($this->entityManager);
        $this->schemaTool->createSchema([
            $this->entityManager->getClassMetadata(Book::class)
        ]);

        $this->bookRepository = $this->entityManager->getRepository(Book::class);
    }

    protected function tearDown(): void
    {
        $this->schemaTool->dropSchema([
            $this->entityManager->getClassMetadata(Book::class)
        ]);

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_book()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $expectedBook = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);

        $this->bookRepository->create($expectedBook);
        $actualBook = $this->entityManager->find(Book::class, $expectedBook->id);

        $this->assertNotEmpty($actualBook->id);
        $this->assertEquals($expectedBook->libraryId, $actualBook->libraryId);
        $this->assertEquals($expectedBook->title, $actualBook->title);
        $this->assertEquals($expectedBook->pageNumber, $actualBook->pageNumber);
        $this->assertEquals($expectedBook->yearLaunched, $actualBook->yearLaunched);
    }

    /** @test */
    public function should_be_throw_an_exception_if_cannot_find_a_book()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Book with id: bookId not found");

        $this->bookRepository->findByPk('bookId');
    }

    /** @test */
    public function should_be_able_to_find_a_book_by_primary_key()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $expectedBook = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedBook));
        $this->entityManager->flush();

        $actualBook = $this->bookRepository->findByPk($expectedBook->id);

        $this->assertEquals($expectedBook->id, $actualBook->id);
        $this->assertEquals($expectedBook->libraryId, $actualBook->libraryId);
        $this->assertEquals($expectedBook->title, $actualBook->title);
        $this->assertEquals($expectedBook->pageNumber, $actualBook->pageNumber);
        $this->assertEquals($expectedBook->yearLaunched, $actualBook->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_find_all_books()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $expectedBook1 = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book1 name',
            'pageNumber' => 196,
            'yearLaunched' => 2001,
        ]);
        $expectedBook2 = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book2 name',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedBook1));
        $this->entityManager->persist($this->toInfrastructureEntity($expectedBook2));
        $this->entityManager->flush();

        $actualBook = $this->bookRepository->findAll();

        $this->assertEquals($expectedBook1->id, $actualBook[0]->id);
        $this->assertEquals($expectedBook1->libraryId, $actualBook[0]->libraryId);
        $this->assertEquals($expectedBook1->title, $actualBook[0]->title);
        $this->assertEquals($expectedBook1->pageNumber, $actualBook[0]->pageNumber);
        $this->assertEquals($expectedBook1->yearLaunched, $actualBook[0]->yearLaunched);
        $this->assertEquals($expectedBook2->yearLaunched, $actualBook[1]->yearLaunched);
    }

    /** @test */
    public function should_be_able_to_update_a_book()
    {
        $library = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'email@email.com'
        ]);
        $expectedBook = BookFactory::create([
            'libraryId' => $library->id,
            'title' => 'Book title',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedBook));
        $this->entityManager->flush();
        $payload = ['title' => 'Book title updated'];
        $expectedBook->update(title: $payload['title']);

        $this->bookRepository->update($expectedBook);
        $actualBook = $this->entityManager->find(Book::class, $expectedBook->id);

        $this->assertEquals($expectedBook->id, $actualBook->id);
        $this->assertEquals($expectedBook->libraryId, $actualBook->libraryId);
        $this->assertEquals($payload['title'], $actualBook->title);
        $this->assertEquals($expectedBook->pageNumber, $actualBook->pageNumber);
        $this->assertEquals($expectedBook->yearLaunched, $actualBook->yearLaunched);
    }

    private function toInfrastructureEntity(Entity $entity): Book
    {
        return new Book(
            id: $entity->id,
            libraryId: $entity->libraryId,
            title: $entity->title,
            pageNumber: $entity->pageNumber,
            yearLaunched: $entity->yearLaunched,
        );
    }
}

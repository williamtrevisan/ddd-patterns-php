<?php

namespace Tests\Feature\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Domain\Factory\BookFactory;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;

class BookRepositoryTest extends TestCase
{
    private EntityManager $entityManager;

    protected function setUp(): void
    {
        parent::setUp();

        $connection = ['driver' => 'pdo_sqlite', 'memory' => true];
        $config = ORMSetup::createAttributeMetadataConfiguration([
            'src/Infrastructure/Doctrine/Model'
        ]);

        $this->entityManager = EntityManager::create($connection, $config);
    }

    protected function tearDown(): void
    {
        $this->entityManager->close();

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_book()
    {
        $book = BookFactory::create([
            'libraryId' => Uuid::uuid4(),
            'title' => 'Book name',
            'pageNumber' => 201,
            'yearLaunched' => 2010,
        ]);

        $persistBook = (new BookRepository())->create($book);

        $this->assertNotEmpty($persistBook->id);
        $this->assertEquals($book->libraryId, $persistBook->libraryId);
        $this->assertEquals($book->title, $persistBook->title);
        $this->assertEquals($book->pageNumber, $persistBook->pageNumber);
        $this->assertEquals($book->yearLaunched, $persistBook->yearLaunched);
    }
}
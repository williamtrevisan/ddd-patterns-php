<?php

namespace Tests\Unit\Infrastructure\Repository;

use Domain\Factory\BookFactory;
use Domain\Repository\BookRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class BookRepositoryUnitTest extends TestCase
{
    private BookRepositoryInterface $bookRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookRepository = Mockery::mock(
            stdClass::class,
            BookRepositoryInterface::class
        );
    }

    protected function tearDown(): void
    {
        Mockery::close();

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
        $this->bookRepository->shouldReceive('create')->andReturn($book);

        $persistBook = $this->bookRepository->create($book);

        $this->bookRepository->shouldHaveReceived('create');
        $this->assertNotEmpty($persistBook->id);
        $this->assertEquals($book->libraryId, $persistBook->libraryId);
        $this->assertEquals($book->title, $persistBook->title);
        $this->assertEquals($book->pageNumber, $persistBook->pageNumber);
        $this->assertEquals($book->yearLaunched, $persistBook->yearLaunched);
    }
}
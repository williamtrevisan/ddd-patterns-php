<?php

namespace Tests\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Domain\Entity\Entity;
use Domain\Factory\AuthorFactory;
use Exception;
use Infrastructure\Entity\Author;
use PHPUnit\Framework\TestCase;

class AuthorRepositoryTest extends TestCase
{
    private EntityRepository $authorRepository;
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
            $this->entityManager->getClassMetadata(Author::class)
        ]);

        $this->authorRepository = $this->entityManager->getRepository(Author::class);
    }

    protected function tearDown(): void
    {
        $this->schemaTool->dropSchema([
            $this->entityManager->getClassMetadata(Author::class)
        ]);

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_author()
    {
        $expectedAuthor = AuthorFactory::create(['name' => 'Author name']);

        $this->authorRepository->create($expectedAuthor);
        $actualAuthor = $this->entityManager->find(Author::class, $expectedAuthor->id);

        $this->assertNotEmpty($actualAuthor->id);
        $this->assertEquals($expectedAuthor->name, $actualAuthor->name);
    }

    /** @test */
    public function should_be_throw_an_exception_if_cannot_find_a_author()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Author with id: authorId not found");

        $this->authorRepository->findByPk('authorId');
    }

    /** @test */
    public function should_be_able_to_find_a_author_by_primary_key()
    {
        $expectedAuthor = AuthorFactory::create(['name' => 'Author name']);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedAuthor));
        $this->entityManager->flush();

        $actualAuthor = $this->authorRepository->findByPk($expectedAuthor->id);

        $this->assertEquals($expectedAuthor->id, $actualAuthor->id);
        $this->assertEquals($expectedAuthor->name, $actualAuthor->name);
    }

    /** @test */
    public function should_be_able_to_find_all_authors()
    {
        $expectedAuthor1 = AuthorFactory::create(['name' => 'Author1 name']);
        $expectedAuthor2 = AuthorFactory::create(['name' => 'Author2 name']);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedAuthor1));
        $this->entityManager->persist($this->toInfrastructureEntity($expectedAuthor2));
        $this->entityManager->flush();

        $actualAuthor = $this->authorRepository->findAll();

        $this->assertEquals($expectedAuthor1->id, $actualAuthor[0]->id);
        $this->assertEquals($expectedAuthor1->name, $actualAuthor[0]->name);
        $this->assertEquals($expectedAuthor2->id, $actualAuthor[1]->id);
        $this->assertEquals($expectedAuthor2->name, $actualAuthor[1]->name);
    }

    /** @test */
    public function should_be_able_to_update_a_author()
    {
        $expectedAuthor = AuthorFactory::create(['name' => 'Author name']);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedAuthor));
        $this->entityManager->flush();
        $payload = ['name' => 'Author name updated'];
        $expectedAuthor->changeName(name: $payload['name']);

        $this->authorRepository->update($expectedAuthor);
        $actualAuthor = $this->entityManager->find(Author::class, $expectedAuthor->id);

        $this->assertEquals($expectedAuthor->id, $actualAuthor->id);
        $this->assertEquals($payload['name'], $actualAuthor->name);
    }

    private function toInfrastructureEntity(Entity $entity): Author
    {
        return new Author(
            id: $entity->id,
            name: $entity->name,
        );
    }
}

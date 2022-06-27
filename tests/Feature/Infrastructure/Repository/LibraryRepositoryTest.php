<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Domain\Entity\Entity;
use Domain\Factory\LibraryFactory;
use Exception;
use Infrastructure\Entity\Library;
use PHPUnit\Framework\TestCase;

class LibraryRepositoryTest extends TestCase
{
    private EntityRepository $libraryRepository;
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
            $this->entityManager->getClassMetadata(Library::class)
        ]);

        $this->libraryRepository = $this->entityManager->getRepository(Library::class);
    }

    protected function tearDown(): void
    {
        $this->schemaTool->dropSchema([
            $this->entityManager->getClassMetadata(Library::class)
        ]);

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_library()
    {
        $expectedLibrary = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'library@email.com',
        ]);

        $this->libraryRepository->create($expectedLibrary);
        $actualLibrary = $this->entityManager->find(Library::class, $expectedLibrary->id);

        $this->assertNotEmpty($actualLibrary->id);
        $this->assertEquals($expectedLibrary->name, $actualLibrary->name);
        $this->assertEquals($expectedLibrary->email, $actualLibrary->email);
    }

    /** @test */
    public function should_be_throw_an_exception_if_cannot_find_a_library()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Library with id: libraryId not found");

        $this->libraryRepository->findByPk('libraryId');
    }

    /** @test */
    public function should_be_able_to_find_a_library_by_primary_key()
    {
        $expectedLibrary = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'library@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedLibrary));
        $this->entityManager->flush();

        $actualLibrary = $this->libraryRepository->findByPk($expectedLibrary->id);

        $this->assertEquals($expectedLibrary->id, $actualLibrary->id);
        $this->assertEquals($expectedLibrary->name, $actualLibrary->name);
        $this->assertEquals($expectedLibrary->email, $actualLibrary->email);
    }

    /** @test */
    public function should_be_able_to_find_all_libraries()
    {
        $expectedLibrary1 = LibraryFactory::create([
            'name' => 'Library1 name',
            'email' => 'library@email.com',
        ]);
        $expectedLibrary2 = LibraryFactory::create([
            'name' => 'Library2 name',
            'email' => 'library@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedLibrary1));
        $this->entityManager->persist($this->toInfrastructureEntity($expectedLibrary2));
        $this->entityManager->flush();

        $actualLibrary = $this->libraryRepository->findAll();

        $this->assertEquals($expectedLibrary1->id, $actualLibrary[0]->id);
        $this->assertEquals($expectedLibrary1->name, $actualLibrary[0]->name);
        $this->assertEquals($expectedLibrary1->email, $actualLibrary[0]->email);
        $this->assertEquals($expectedLibrary2->id, $actualLibrary[1]->id);
        $this->assertEquals($expectedLibrary2->name, $actualLibrary[1]->name);
        $this->assertEquals($expectedLibrary2->email, $actualLibrary[1]->email);
    }

    /** @test */
    public function should_be_able_to_update_a_library()
    {
        $expectedLibrary = LibraryFactory::create([
            'name' => 'Library name',
            'email' => 'library@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedLibrary));
        $this->entityManager->flush();
        $payload = ['name' => 'Library name updated'];
        $expectedLibrary->update(name: $payload['name']);

        $this->libraryRepository->update($expectedLibrary);
        $actualLibrary = $this->entityManager->find(Library::class, $expectedLibrary->id);

        $this->assertEquals($expectedLibrary->id, $actualLibrary->id);
        $this->assertEquals($payload['name'], $actualLibrary->name);
        $this->assertEquals($expectedLibrary->email, $actualLibrary->email);
    }

    private function toInfrastructureEntity(Entity $entity): Library
    {
        return new Library(
            id: $entity->id,
            name: $entity->name,
            email: $entity->email,
        );
    }
}

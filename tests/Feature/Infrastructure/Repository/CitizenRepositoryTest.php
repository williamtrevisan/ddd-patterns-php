<?php

declare(strict_types=1);

namespace Tests\Infrastructure\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMSetup;
use Doctrine\ORM\Tools\SchemaTool;
use Domain\Entity\Entity;
use Domain\Factory\CitizenFactory;
use Exception;
use Infrastructure\Entity\Citizen;
use PHPUnit\Framework\TestCase;

class CitizenRepositoryTest extends TestCase
{
    private EntityRepository $citizenRepository;
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
            $this->entityManager->getClassMetadata(Citizen::class)
        ]);

        $this->citizenRepository = $this->entityManager->getRepository(Citizen::class);
    }

    protected function tearDown(): void
    {
        $this->schemaTool->dropSchema([
            $this->entityManager->getClassMetadata(Citizen::class)
        ]);

        parent::tearDown();
    }

    /** @test */
    public function should_be_able_to_create_a_new_citizen()
    {
        $expectedCitizen = CitizenFactory::create([
            'name' => 'Citizen name',
            'email' => 'citizen@email.com',
        ]);

        $this->citizenRepository->create($expectedCitizen);
        $actualCitizen = $this->entityManager->find(Citizen::class, $expectedCitizen->id);

        $this->assertNotEmpty($actualCitizen->id);
        $this->assertEquals($expectedCitizen->name, $actualCitizen->name);
        $this->assertEquals($expectedCitizen->email, $actualCitizen->email);
    }

    /** @test */
    public function should_be_throw_an_exception_if_cannot_find_a_citizen()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Citizen with id: citizenId not found");

        $this->citizenRepository->findByPk('citizenId');
    }

    /** @test */
    public function should_be_able_to_find_a_citizen_by_primary_key()
    {
        $expectedCitizen = CitizenFactory::create([
            'name' => 'Citizen name',
            'email' => 'citizen@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedCitizen));
        $this->entityManager->flush();

        $actualCitizen = $this->citizenRepository->findByPk($expectedCitizen->id);

        $this->assertEquals($expectedCitizen->id, $actualCitizen->id);
        $this->assertEquals($expectedCitizen->name, $actualCitizen->name);
        $this->assertEquals($expectedCitizen->email, $actualCitizen->email);
    }

    /** @test */
    public function should_be_able_to_find_all_citizens()
    {
        $expectedCitizen1 = CitizenFactory::create([
            'name' => 'Citizen1 name',
            'email' => 'citizen@email.com',
        ]);
        $expectedCitizen2 = CitizenFactory::create([
            'name' => 'Citizen2 name',
            'email' => 'citizen@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedCitizen1));
        $this->entityManager->persist($this->toInfrastructureEntity($expectedCitizen2));
        $this->entityManager->flush();

        $actualCitizen = $this->citizenRepository->findAll();

        $this->assertEquals($expectedCitizen1->id, $actualCitizen[0]->id);
        $this->assertEquals($expectedCitizen1->name, $actualCitizen[0]->name);
        $this->assertEquals($expectedCitizen1->email, $actualCitizen[0]->email);
        $this->assertEquals($expectedCitizen2->id, $actualCitizen[1]->id);
        $this->assertEquals($expectedCitizen2->name, $actualCitizen[1]->name);
        $this->assertEquals($expectedCitizen2->email, $actualCitizen[1]->email);
    }

    /** @test */
    public function should_be_able_to_update_a_citizen()
    {
        $expectedCitizen = CitizenFactory::create([
            'name' => 'Citizen name',
            'email' => 'citizen@email.com',
        ]);
        $this->entityManager->persist($this->toInfrastructureEntity($expectedCitizen));
        $this->entityManager->flush();
        $payload = ['name' => 'Citizen name updated'];
        $expectedCitizen->update(name: $payload['name']);

        $this->citizenRepository->update($expectedCitizen);
        $actualCitizen = $this->entityManager->find(Citizen::class, $expectedCitizen->id);

        $this->assertEquals($expectedCitizen->id, $actualCitizen->id);
        $this->assertEquals($payload['name'], $actualCitizen->name);
        $this->assertEquals($expectedCitizen->email, $actualCitizen->email);
    }

    private function toInfrastructureEntity(Entity $entity): Citizen
    {
        return new Citizen(
            id: $entity->id,
            name: $entity->name,
            email: $entity->email,
        );
    }
}

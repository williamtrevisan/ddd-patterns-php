<?php

declare(strict_types=1);

namespace Infrastructure\Citizen\Doctrine\Repository;

use Doctrine\ORM\EntityRepository;
use Domain\Citizen\Entity\Citizen as DomainCitizen;
use Domain\Citizen\Repository\CitizenRepositoryInterface;
use Domain\shared\Entity\Entity;
use Exception;
use Infrastructure\Citizen\Doctrine\Entity\Citizen as InfrastructureCitizen;

class CitizenRepository extends EntityRepository implements CitizenRepositoryInterface
{
    public function create(Entity $entity): void
    {
        $this->getEntityManager()->persist($this->toInfrastructureEntity($entity));
        $this->getEntityManager()->flush();
    }

    public function findByPk(string $id): Entity
    {
        $citizen = $this->find($id);
        if (! $citizen) {
            throw new Exception("Citizen with id: $id not found");
        }

        return $this->toDomainEntity($citizen);
    }

    public function findAll(): array
    {
        $citizens = parent::findAll();

        return array_map(fn ($citizen) => $this->toDomainEntity($citizen), $citizens);
    }

    public function update(Entity $entity): void
    {
        $citizen = $this->find($entity->id);
        if (! $citizen) {
            throw new Exception("Book with id: $entity->id not found");
        }

        $citizen->setName($entity->name);
        $citizen->setEmail($entity->email);

        $this->getEntityManager()->flush();
    }

    private function toDomainEntity(object $object): Entity
    {
        return new DomainCitizen(
            id: $object->getId(),
            name: $object->getName(),
            email: $object->getEmail(),
        );
    }

    private function toInfrastructureEntity(Entity $entity): InfrastructureCitizen
    {
        return new InfrastructureCitizen(
            id: $entity->id,
            name: $entity->name,
            email: $entity->email,
        );
    }
}

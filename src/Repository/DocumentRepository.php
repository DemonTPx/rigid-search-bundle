<?php

namespace Demontpx\RigidSearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @copyright 2015 Bert Hekman
 */
class DocumentRepository extends EntityRepository
{
    public function delete(string $type, int $typeId): void
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type AND d.typeId = :type_id');

        $queryBuilder->getQuery()->execute([
            'type' => $type,
            'type_id' => $typeId,
        ]);
    }

    public function truncateType(string $type): void
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type');

        $queryBuilder->getQuery()->execute(['type' => $type]);
    }

    public function truncate(): void
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete();

        $queryBuilder->getQuery()->execute();
    }
}

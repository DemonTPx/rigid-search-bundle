<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Repository;

use Demontpx\RigidSearchBundle\Entity\Document;
use Demontpx\UtilBundle\Repository\AbstractEntityRepository;

/**
 * @copyright 2015 Bert Hekman
 */
class DocumentRepository extends AbstractEntityRepository
{
    protected function getClassName(): string
    {
        return Document::class;
    }

    public function find(int $id): ?Document
    {
        return $this->repository->find($id);
    }

    public function delete(string $type, int $typeId): void
    {
        $queryBuilder = $this->repository->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type AND d.typeId = :type_id');

        $queryBuilder->getQuery()->execute([
            'type' => $type,
            'type_id' => $typeId,
        ]);
    }

    public function truncateType(string $type): void
    {
        $queryBuilder = $this->repository->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type');

        $queryBuilder->getQuery()->execute(['type' => $type]);
    }

    public function truncate(): void
    {
        $queryBuilder = $this->repository->createQueryBuilder('d');
        $queryBuilder->delete();

        $queryBuilder->getQuery()->execute();
    }
}

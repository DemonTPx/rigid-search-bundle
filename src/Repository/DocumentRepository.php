<?php

namespace Demontpx\RigidSearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class DocumentRepository
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class DocumentRepository extends EntityRepository
{
    /**
     * @param string $type
     * @param int    $typeId
     */
    public function delete($type, $typeId)
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type AND d.typeId = :type_id');

        $queryBuilder->getQuery()->execute([
            'type' => $type,
            'type_id' => $typeId,
        ]);
    }

    /**
     * @param string $type
     */
    public function truncateType($type)
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete()
            ->where('d.type = :type');

        $queryBuilder->getQuery()->execute(['type' => $type]);
    }

    public function truncate()
    {
        $queryBuilder = $this->createQueryBuilder('d');
        $queryBuilder->delete();

        $queryBuilder->getQuery()->execute();
    }
}

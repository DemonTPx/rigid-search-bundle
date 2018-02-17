<?php

namespace Demontpx\RigidSearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * @copyright 2015 Bert Hekman
 */
class FieldRepository extends EntityRepository
{
    /**
     * @param string[] $tokenList
     *
     * @return float[]
     */
    public function search(array $tokenList, int $offset = 0, int $limit = 10, string $publishDate = 'now'): array
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $queryBuilder->select('IDENTITY(f.document) AS id')
            ->groupBy('f.document')
            ->orderBy('score', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $scorePartList = [];
        foreach ($tokenList as $index => $token) {
            $key = 'token_' . (int) $index;

            $scorePartList[] = 'CASE WHEN f.text LIKE :' . $key . ' THEN f.weight ELSE 0 END';
            $queryBuilder->orWhere('f.text LIKE :' . $key);
            $queryBuilder->setParameter($key, '%' . $token . '%');
        }
        $queryBuilder->addSelect('SUM(' . implode(' + ', $scorePartList) . ') AS score');

        $queryBuilder->join('f.document', 'd')
            ->andWhere('d.publishDate < :now')
            ->setParameter('now', new \DateTime($publishDate))
            ->addOrderBy('d.publishDate', 'DESC');

        return array_column($queryBuilder->getQuery()->getArrayResult(), 'score', 'id');
    }

    /**
     * @param string[] $tokenList
     */
    public function count(array $tokenList, string $publishDate = 'now'): int
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $queryBuilder->select('COUNT(DISTINCT f.document)');

        foreach ($tokenList as $index => $token) {
            $key = 'token_' . (int) $index;

            $queryBuilder->orWhere('f.text LIKE :' . $key);
            $queryBuilder->setParameter($key, '%' . $token . '%');
        }

        $queryBuilder->join('f.document', 'd')
            ->andWhere('d.publishDate < :now')
            ->setParameter('now', new \DateTime($publishDate));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}

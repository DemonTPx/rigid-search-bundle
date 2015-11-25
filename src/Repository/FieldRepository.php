<?php

namespace Demontpx\RigidSearchBundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Class FieldRepository
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class FieldRepository extends EntityRepository
{
    /**
     * @param string[] $tokenList
     * @param int      $offset
     * @param int      $limit
     *
     * @return float[]
     */
    public function search($tokenList, $offset = 0, $limit = 10)
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $queryBuilder->select('IDENTITY(f.document) AS id')
            ->groupBy('f.document')
            ->orderBy('score', 'DESC')
            ->setFirstResult($offset)
            ->setMaxResults($limit);

        $scorePartList = [];
        $namedTokenList = [];
        foreach ($tokenList as $index => $token) {
            $key = 'token_' . (int) $index;

            $scorePartList[] = 'CASE WHEN f.text LIKE :' . $key . ' THEN f.weight ELSE 0 END';
            $queryBuilder->orWhere('f.text LIKE :' . $key);
            $namedTokenList[$key] = '%' . $token . '%';
        }
        $queryBuilder->addSelect('SUM(' . implode(' + ', $scorePartList) . ') AS score');
        $queryBuilder->setParameters($namedTokenList);

        return array_column($queryBuilder->getQuery()->getArrayResult(), 'score', 'id');
    }

    /**
     * @param string[] $tokenList
     *
     * @return int
     */
    public function count($tokenList)
    {
        $queryBuilder = $this->createQueryBuilder('f');
        $queryBuilder->select('COUNT(DISTINCT f.document)');

        $namedTokenList = [];
        foreach ($tokenList as $index => $token) {
            $key = 'token_' . (int) $index;

            $queryBuilder->orWhere('f.text LIKE :' . $key);
            $namedTokenList[$key] = '%' . $token . '%';
        }
        $queryBuilder->setParameters($namedTokenList);

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}

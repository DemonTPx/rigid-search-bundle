<?php

namespace Demontpx\RigidSearchBundle\Search\Index;

use Demontpx\RigidSearchBundle\Entity\Document as OrmDocument;
use Demontpx\RigidSearchBundle\Model\Document;
use Demontpx\RigidSearchBundle\Model\ScoredDocument;
use Demontpx\RigidSearchBundle\Repository\DocumentRepository;
use Demontpx\RigidSearchBundle\Repository\FieldRepository;
use Doctrine\ORM\EntityManager;

/**
 * Class OrmIndex
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class OrmIndex implements IndexInterface
{
    /** @var EntityManager */
    private $entityManager;

    /** @var DocumentRepository */
    private $documentRepository;

    /** @var FieldRepository */
    private $fieldRepository;

    /**
     * @param EntityManager      $entityManager
     * @param DocumentRepository $documentRepository
     * @param FieldRepository    $fieldRepository
     */
    public function __construct(
        EntityManager $entityManager,
        DocumentRepository $documentRepository,
        FieldRepository $fieldRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->documentRepository = $documentRepository;
        $this->fieldRepository = $fieldRepository;
    }

    public function add($type, $id, Document $document)
    {
        $this->documentRepository->delete($type, $id);

        $ormDocument = OrmDocument::fromDocument($type, $id, $document);

        $this->entityManager->persist($ormDocument);
        $this->entityManager->flush($ormDocument);
    }

    public function remove($type, $id)
    {
        $this->documentRepository->delete($type, $id);
    }

    public function removeType($type)
    {
        $this->documentRepository->truncateType($type);
    }

    public function removeAll()
    {
        $this->documentRepository->truncate();
    }

    public function count(array $tokenList)
    {
        return $this->fieldRepository->count($tokenList);
    }

    public function search(array $tokenList, $offset = 0, $limit = 10)
    {
        $searchResultList = $this->fieldRepository->search($tokenList, $offset, $limit);

        $resultList = [];
        foreach ($searchResultList as $id => $score) {
            /** @var OrmDocument $document */
            $document = $this->documentRepository->find($id);
            $resultList[] = new ScoredDocument($document, $score);
        }

        return $resultList;
    }
}

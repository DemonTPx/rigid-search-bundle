<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Search\Index;

use Demontpx\RigidSearchBundle\Entity\Document as OrmDocument;
use Demontpx\RigidSearchBundle\Model\Document;
use Demontpx\RigidSearchBundle\Model\ScoredDocument;
use Demontpx\RigidSearchBundle\Repository\DocumentRepository;
use Demontpx\RigidSearchBundle\Repository\FieldRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @copyright 2015 Bert Hekman
 */
class OrmIndex implements IndexInterface
{
    /** @var EntityManagerInterface */
    private $entityManager;
    /** @var DocumentRepository */
    private $documentRepository;
    /** @var FieldRepository */
    private $fieldRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        DocumentRepository $documentRepository,
        FieldRepository $fieldRepository
    )
    {
        $this->entityManager = $entityManager;
        $this->documentRepository = $documentRepository;
        $this->fieldRepository = $fieldRepository;
    }

    public function add(string $type, int $id, Document $document): void
    {
        $this->documentRepository->delete($type, $id);

        $ormDocument = OrmDocument::fromDocument($type, $id, $document);

        $this->entityManager->persist($ormDocument);
        $this->entityManager->flush($ormDocument);
    }

    public function remove(string $type, int $id): void
    {
        $this->documentRepository->delete($type, $id);
    }

    public function removeType(string $type): void
    {
        $this->documentRepository->truncateType($type);
    }

    public function removeAll(): void
    {
        $this->documentRepository->truncate();
    }

    public function count(array $tokenList): int
    {
        if (count($tokenList) == 0) {
            return 0;
        }

        return $this->fieldRepository->count($tokenList);
    }

    public function search(array $tokenList, int $offset = 0, int $limit = 10): array
    {
        if (count($tokenList) == 0) {
            return [];
        }

        $searchResultList = $this->fieldRepository->search($tokenList, $offset, $limit);

        $resultList = [];
        foreach ($searchResultList as $id => $score) {
            $document = $this->documentRepository->find($id);
            $resultList[] = new ScoredDocument($document, (float) $score);
        }

        return $resultList;
    }
}

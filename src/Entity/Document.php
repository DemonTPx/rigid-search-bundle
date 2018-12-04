<?php

namespace Demontpx\RigidSearchBundle\Entity;

use Demontpx\RigidSearchBundle\Model\Document as BaseDocument;
use Demontpx\RigidSearchBundle\Model\Field as BaseField;
use Demontpx\UtilBundle\Entity\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @copyright 2015 Bert Hekman
 *
 * @ORM\Entity()
 * @ORM\Table(name="search_document", uniqueConstraints={
 *      @ORM\UniqueConstraint(columns={"type", "type_id"})
 * })
 */
class Document extends BaseDocument
{
    use IdTrait;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $type;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $typeId;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    protected $title;

    /**
     * @var string
     *
     * @ORM\Column(type="text", nullable=true)
     */
    protected $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=1024)
     */
    protected $url;

    /**
     * @var ArrayCollection|Field[]
     *
     * @ORM\OneToMany(targetEntity="Field", mappedBy="document", cascade={"all"}, orphanRemoval=true, fetch="EAGER")
     */
    protected $fieldList;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(type="datetime")
     */
    protected $publishDate;

    /**
     * @param Field[]   $fieldList
     */
    public function __construct(
        string $type,
        int $typeId,
        string $title,
        string $description,
        \DateTimeInterface $publishDate,
        string $url,
        array $fieldList = []
    )
    {
        parent::__construct($title, $description, $publishDate, $url, []);

        $this->type = $type;
        $this->typeId = $typeId;
        $this->fieldList = new ArrayCollection();
        foreach ($fieldList as $field) {
            $this->addField($field);
        }
    }

    public static function fromDocument(string $type, int $typeId, BaseDocument $document): Document
    {
        return new Document(
            $type,
            $typeId,
            $document->title,
            $document->description,
            $document->publishDate,
            $document->url,
            $document->fieldList
        );
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType(string $type)
    {
        $this->type = $type;
    }

    public function getTypeId(): int
    {
        return $this->typeId;
    }

    public function setTypeId(int $typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * @return Field[]
     */
    public function getFieldList(): array
    {
        return $this->fieldList->toArray();
    }

    /**
     * @param ArrayCollection|BaseField[] $fieldList
     */
    public function setFieldList(array $fieldList)
    {
        if ( ! $fieldList instanceof ArrayCollection) {
            $fieldList = new ArrayCollection($fieldList);
        }

        $this->fieldList = $fieldList;
    }

    public function addField(BaseField $field)
    {
        if ( ! $field instanceof Field) {
            $field = Field::fromField($this, $field);
        }

        $field->setDocument($this);
        $this->fieldList->add($field);
    }
}

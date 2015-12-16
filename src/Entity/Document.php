<?php

namespace Demontpx\RigidSearchBundle\Entity;

use Demontpx\RigidSearchBundle\Model\Document as BaseDocument;
use Demontpx\RigidSearchBundle\Model\Field as BaseField;
use Demontpx\UtilBundle\Entity\IdTrait;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Document
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 *
 * @ORM\Entity(repositoryClass="Demontpx\RigidSearchBundle\Repository\DocumentRepository")
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
     * @param string  $type
     * @param int     $typeId
     * @param string  $title
     * @param string  $description
     * @param string  $url
     * @param Field[] $fieldList
     */
    public function __construct($type, $typeId, $title, $description, $url, $fieldList = [])
    {
        parent::__construct($title, $description, $url, []);

        $this->type = $type;
        $this->typeId = $typeId;
        $this->fieldList = new ArrayCollection();
        foreach ($fieldList as $field) {
            $this->addField($field);
        }
    }

    /**
     * @param string       $type
     * @param int          $typeId
     * @param BaseDocument $document
     *
     * @return Document
     */
    public static function fromDocument($type, $typeId, BaseDocument $document)
    {
        return new self($type, $typeId, $document->title, $document->description, $document->url, $document->fieldList);
    }

    /**
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType($type)
    {
        $this->type = $type;
    }

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * @return Field[]
     */
    public function getFieldList()
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

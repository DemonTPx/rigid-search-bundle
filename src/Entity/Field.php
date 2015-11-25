<?php

namespace Demontpx\RigidSearchBundle\Entity;

use Demontpx\RigidSearchBundle\Model\Field as BaseField;
use Demontpx\UtilBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Field
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 *
 * @ORM\Entity(repositoryClass="Demontpx\RigidSearchBundle\Repository\FieldRepository")
 * @ORM\Table(name="search_field")
 */
class Field extends BaseField
{
    use IdTrait;

    /**
     * @var Document
     *
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="fieldList")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected $document;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     */
    protected $text;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=64)
     */
    protected $name;

    /**
     * @var float
     *
     * @ORM\Column(type="float")
     */
    protected $weight;

    /**
     * @param Document $document
     * @param string   $text
     * @param string   $name
     * @param float    $weight
     */
    public function __construct(Document $document, $text, $name, $weight)
    {
        $this->document = $document;

        parent::__construct($text, $name, $weight);
    }

    /**
     * @param Document  $document
     * @param BaseField $field
     *
     * @return Field
     */
    public static function fromField(Document $document, BaseField $field)
    {
        return new self($document, $field->name, $field->text, $field->weight);
    }

    /**
     * @return Document
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param Document $document
     */
    public function setDocument(Document $document)
    {
        $this->document = $document;
    }
}

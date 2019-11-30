<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Entity;

use Demontpx\RigidSearchBundle\Model\Field as BaseField;
use Demontpx\UtilBundle\Entity\IdTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @copyright 2015 Bert Hekman
 *
 * @ORM\Entity()
 * @ORM\Table(name="search_field")
 */
class Field extends BaseField
{
    use IdTrait;

    /**
     * @ORM\ManyToOne(targetEntity="Document", inversedBy="fieldList")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    protected Document $document;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    protected string $text;

    /**
     * @ORM\Column(type="string", length=64)
     */
    protected string $name;

    /**
     * @ORM\Column(type="float")
     */
    protected float $weight;

    public function __construct(Document $document, string $text, string $name, float $weight)
    {
        $this->document = $document;

        parent::__construct($text, $name, $weight);
    }

    public static function fromField(Document $document, BaseField $field): Field
    {
        return new Field($document, $field->name, $field->text, $field->weight);
    }

    public function getDocument(): Document
    {
        return $this->document;
    }

    public function setDocument(Document $document)
    {
        $this->document = $document;
    }
}

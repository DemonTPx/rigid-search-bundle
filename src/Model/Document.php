<?php declare(strict_types=1);

namespace Demontpx\RigidSearchBundle\Model;

/**
 * @copyright 2015 Bert Hekman
 */
class Document
{
    protected string $title;
    protected string $description;
    protected \DateTimeInterface $publishDate;
    protected string $url;
    /** @var Field[] */
    protected $fieldList;

    /**
     * @param Field[] $fieldList
     */
    public function __construct(
        string $title,
        string $description,
        \DateTimeInterface $publishDate,
        string $url,
        array $fieldList = []
    )
    {
        $this->title = $title;
        $this->description = $description;
        $this->publishDate = $publishDate;
        $this->url = $url;
        $this->fieldList = $fieldList;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = $title;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getPublishDate(): \DateTimeInterface
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTimeInterface $publishDate)
    {
        $this->publishDate = $publishDate;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url)
    {
        $this->url = $url;
    }

    /**
     * @return Field[]
     */
    public function getFieldList(): array
    {
        return $this->fieldList;
    }

    /**
     * @param Field[] $fieldList
     */
    public function setFieldList(array $fieldList)
    {
        $this->fieldList = $fieldList;
    }

    public function addField(Field $field)
    {
        $this->fieldList[$field->getName()] = $field;
    }
}

<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * @copyright 2015 Bert Hekman
 */
class Document
{
    /** @var string */
    protected $title;

    /** @var string */
    protected $description;

    /** @var \DateTime */
    protected $publishDate;

    /** @var string */
    protected $url;

    /** @var Field[] */
    protected $fieldList;

    /**
     * @param Field[]   $fieldList
     */
    public function __construct(
        string $title,
        string $description,
        \DateTime $publishDate,
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

    public function getPublishDate(): \DateTime
    {
        return $this->publishDate;
    }

    public function setPublishDate(\DateTime $publishDate)
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

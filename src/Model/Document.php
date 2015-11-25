<?php

namespace Demontpx\RigidSearchBundle\Model;

/**
 * Class Document
 *
 * @author    Bert Hekman <demontpx@gmail.com>
 * @copyright 2015 Bert Hekman
 */
class Document
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Field[]
     */
    protected $fieldList;

    /**
     * @param string  $title
     * @param string  $description
     * @param string  $url
     * @param Field[] $fieldList
     */
    public function __construct($title, $description, $url, array $fieldList = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->fieldList = $fieldList;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription($description)
    {
        $this->description = $description;
    }

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return Field[]
     */
    public function getFieldList()
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

    /**
     * @param Field $field
     */
    public function addField(Field $field)
    {
        $this->fieldList[$field->getName()] = $field;
    }
}

<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

use Amorphine\BitrixRestQl\Entities\Entity;

abstract class ObjectType
{
    protected $fields = [];

    protected $name;

    protected $method;

    protected $listMethod;

    public function __construct($fields = [])
    {
        if ($fields) {
            $this->fields = $fields;
        }
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @param array $fields
     */
    public function setFields(array $fields): void
    {
        $this->fields = $fields;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getListMethod()
    {
        return $this->listMethod;
    }

    /**
     * @param mixed $listMethod
     */
    public function setListMethod($listMethod): void
    {
        $this->listMethod = $listMethod;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method): void
    {
        $this->method = $method;
    }

    public static function getType() {
        return (new static());
    }

    abstract public function getEntity($data): Entity;
}

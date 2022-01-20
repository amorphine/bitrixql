<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

class ListType
{
    protected $type;

    public function __construct(ObjectType $type)
    {
        $this->type = $type;

        if (!$this->type->getListMethod()) {
            throw new \Exception("Type {$type->getName()} does not support list method");
        }
    }

    /**
     * @return ObjectType
     */
    public function getType(): ObjectType
    {
        return $this->type;
    }

    /**
     * @param ObjectType $type
     */
    public function setType(ObjectType $type): void
    {
        $this->type = $type;
    }

    /**
     * @param $type
     *
     * @return static
     * @throws \Exception
     */
    public static function forType($type): ListType {
        return new static($type);
    }

    /**
     * @param $list
     *
     * @return \Generator
     */
    public function getEntityList($list)
    {
        foreach ($list as $value) {
            yield $this->getType()->getEntity($value);
        }
    }
}

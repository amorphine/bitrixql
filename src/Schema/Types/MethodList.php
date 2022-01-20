<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

use Amorphine\BitrixRestQl\Entities\Entity;
use Amorphine\BitrixRestQl\Entities\MethodList as MethodEntity;

class MethodList extends ObjectType
{
    protected $name = 'methods';

    protected $method = 'methods';

    public function getEntity($data): Entity
    {
        return new MethodEntity($data);
    }
}

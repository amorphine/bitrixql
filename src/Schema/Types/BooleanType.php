<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

class BooleanType extends ScalarType
{
    public function getEntity($data): bool
    {
        return !!$data;
    }
}

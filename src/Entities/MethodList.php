<?php

namespace Amorphine\BitrixRestQl\Entities;

class MethodList extends Entity
{
    public function getList(): array
    {
        return $this->data;
    }
}

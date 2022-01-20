<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

abstract class ScalarType
{
    public abstract function getEntity($data);
}

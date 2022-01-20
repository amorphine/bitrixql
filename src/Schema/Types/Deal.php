<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

use Amorphine\BitrixRestQl\Entities\Deal as DealEntity;

class Deal extends ObjectType
{
    protected $fields = [
        'id' => 'ID'
    ];

    protected $name = 'deal';

    protected $method = 'crm.contact.get';

    protected $listMethod = 'crm.deal.list';

    public function getEntity($data): DealEntity
    {
        return new DealEntity($data);
    }
}

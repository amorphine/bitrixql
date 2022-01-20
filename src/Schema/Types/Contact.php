<?php

namespace Amorphine\BitrixRestQl\Schema\Types;

use Amorphine\BitrixRestQl\Entities\Contact as ContactEntity;

class Contact extends ObjectType
{
    protected $fields = [
        'id' => 'ID'
    ];

    protected $name = 'contact';

    protected $method = 'crm.contact.get';

    protected $listMethod = 'crm.contact.list';

    public function getEntity($data): ContactEntity
    {
        return new ContactEntity($data);
    }
}

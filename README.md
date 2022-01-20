# BitrixQL

BitrixQL is a library for interaction with Bitrix REST API
Inspired by GraphQL it's recalled to make queries in a declarative way

`The code is in the early development and may have never be finished. PLEASE DO NOT USE IT.`

Usage example:

```php
use Amorphine\BitrixRestQl\DataLoader;
use Amorphine\BitrixRestQl\Query\BitrixQueryExecutor;
use Amorphine\BitrixRestQl\Schema\Types\Contact;
use Amorphine\BitrixRestQl\Schema\Types\Deal;
use Amorphine\BitrixRestQl\Schema\Types\ListType;
use Amorphine\BitrixRestQl\Schema\Types\MethodList;

require('vendor/autoload.php');

$schema = [
    'contacts' => [
        'type' => ListType::forType(
            Contact::getType()
        ),
    ],
    'contact' => [
        'type' => Contact::getType(),
    ],
    'deals' => [
        'type' => ListType::forType(
            Deal::getType()
        ),
    ],
    'methods' => array(
        'type' => MethodList::getType(),
    )
];

$queryExecutor = new BitrixQueryExecutor(
    'url', 'userId', 'hook_key'
);

$loader = new DataLoader($schema, $queryExecutor);

$data = $loader->executeQuery([
    'getContacts' => [
        'type' => 'contacts',
        'payload' => [
            'filter' => [
                'UF_CRM_1520345086' => '32',
            ]
        ],
    ],

    'contact' => [
        'type' => 'contact',
        'payload' => [
            'id' => '$result[getContacts][0][ID]',
        ],
    ],

    'deals' => [
        'type' => 'deals',
        'payload' => [
            'CONTACT_ID' => '$result[contact][ID]'
        ]
    ],

    'deals2' => [
        'type' => 'deals',
        'payload' => [
            'CONTACT_ID' => '$result[contact][ID]'
        ]
    ],

    'methods' => [
        'type' => 'methods',
    ]
]);
```

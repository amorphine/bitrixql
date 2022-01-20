<?php

namespace Amorphine\BitrixRestQl;

use Amorphine\BitrixRestQl\Query\BatchQuery;
use Amorphine\BitrixRestQl\Query\IBitrixQueryExecutor;
use Amorphine\BitrixRestQl\Query\Query;
use Amorphine\BitrixRestQl\Schema\Types\ListType;
use Amorphine\BitrixRestQl\Schema\Types\ObjectType;
use Amorphine\BitrixRestQl\Schema\Types\ScalarType;

class DataLoader
{
    private $schema;

    private IBitrixQueryExecutor $queryExecutor;

    /**
     * @param $schema
     */
    public function __construct($schema, $queryExecutor)
    {
        $this->schema = $schema;

        $this->queryExecutor = $queryExecutor;
    }

    public function executeQuery(array $querySchema)
    {
        $queries = $this->bindTypesToQuerySchema($querySchema);

        $batch = new BatchQuery();

        if (count($queries) > 1) {
            $batch = new BatchQuery();

            foreach ($queries as $queryName => $querySchemaItem) {
                $batch->appendQuery($queryName, $querySchemaItem['query']);
            }
        }

        $batchQueryCall = $this->queryExecutor->executeBatchQuery($batch);

        $batchQueryResponse = $batchQueryCall->getResponse();

        $batchQueryResult = $batchQueryCall->getResult();

        $result = [];

        foreach ($batchQueryResult as $queryName => $queryResult) {
            $type = $queries[$queryName]['type'];

            if ($type instanceof ObjectType | $type instanceof ScalarType) {
                $entity = $type->getEntity($queryResult);
            } elseif ($type instanceof ListType) {
                $entity = $type->getEntityList($queryResult);
            }

            $result[$queryName] = $entity;
        }

        return $result;
    }

    private function resolveType($name)
    {
        return $this->schema[$name]['type'];
    }

    private function bindTypesToQuerySchema(array $querySchema): array
    {
        $queryList = [];

        foreach ($querySchema as $key => $value) {
            /**
             * @var ObjectType|ListType $type
             */
            $type = $this->resolveType($value['type']);

            if ($type instanceof ObjectType) {
                $method = $type->getMethod();
            } elseif ($type instanceof ListType) {
                $method = $type->getType()->getListMethod();
            }

            $payload = $value['payload'] ?? [];

            $queryList[$key] = [
                'type' => $type,
                'query' => new Query($method, $payload),
            ];
        }

        return $queryList;
    }
}

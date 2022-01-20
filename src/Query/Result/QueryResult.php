<?php

namespace Amorphine\BitrixRestQl\Query\Result;

use Amorphine\BitrixRestQl\Query\BatchQuery;
use Amorphine\BitrixRestQl\Query\IBitrixQueryExecutor;
use Amorphine\BitrixRestQl\Query\Query;

class QueryResult
{
    protected Query $query;

    protected IBitrixQueryExecutor $executor;

    /**
     * @var mixed[]
     */
    protected array $response;

    /**
     * @param mixed[] $response
     * @param Query $query
     * @param IBitrixQueryExecutor $executor
     */
    public function __construct(array $response, Query $query, IBitrixQueryExecutor $executor)
    {
        $this->executor = $executor;
        $this->query = $query;
        $this->response = $response;
    }

    /**
     * @return array{result: array, time: string}
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @return BatchQuery
     */
    public function getQuery(): Query
    {
        return $this->query;
    }

    /**
     * @return IBitrixQueryExecutor
     */
    public function getExecutor(): IBitrixQueryExecutor
    {
        return $this->executor;
    }
}

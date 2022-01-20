<?php

declare(strict_types=1);

namespace Amorphine\BitrixRestQl\Query\Result;

use Amorphine\BitrixRestQl\Query\Result\BatchQueryResult;

/**
 * Batch query instance with defined query name to operate with pagination for further queries
 */
class BoundBatchQueryResult extends BatchQueryResult
{
    private string $queryName;

    public function __construct(BatchQueryResult $parentResult, string $queryName)
    {
        parent::__construct($parentResult->getResponse(), $parentResult->getQuery(), $parentResult->getExecutor());

        $this->queryName = $queryName;
    }

    public function getNextCount($key = ''): int
    {
        return parent::getNextCount($key ?: $this->queryName);
    }

    public function getTotal(string $key = '')
    {
        return parent::getTotal($key ?: $this->queryName);
    }

    public function getTime(string $key = '')
    {
        return parent::getTime($key ?: $this->queryName);
    }

    public function next(array $startMap = []): BatchQueryResult
    {
        if ($startMap) {
            return parent::next($startMap);
        }

        return parent::next([
            $this->queryName => $this->getNextCount()
        ]);
    }
}

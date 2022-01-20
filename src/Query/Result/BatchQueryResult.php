<?php

namespace Amorphine\BitrixRestQl\Query\Result;


use Amorphine\BitrixRestQl\Query\BatchQuery;
use Amorphine\BitrixRestQl\Query\IBitrixQueryExecutor;
use Amorphine\BitrixRestQl\Query\Result\QueryResult;

class BatchQueryResult extends QueryResult
{
    /**
     * @param array $response
     * @param BatchQuery $query
     * @param IBitrixQueryExecutor $executor
     */
    public function __construct(array $response, BatchQuery $query, IBitrixQueryExecutor $executor)
    {
        parent::__construct($response, $query, $executor);

        $this->query = $query;
        $this->executor = $executor;
        $this->response = $response;
    }

    /**
     * @return int
     */
    public function getNextCount($key): int
    {
        return $this->response['result']['result_next'][$key] ?? 0;
    }

    /**
     * @return array<mixed>
     */
    public function getResult(string $key = '')
    {
        if (!$key) {
            return $this->response['result']['result'] ?? [];
        }

        return $this->response['result']['result'][$key] ?? [];
    }

    /**
     * @return array{start: float, finish: float, duration: float, processing: float, date_start: string, date_finish: string}
     */
    public function getTime(string $key)
    {
        return $this->response['result']['result_time'][$key] ?? null;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    public function getTotal(string $key)
    {
        return $this->getResult('result_total')[$key] ?? null;
    }

    /**
     * @return BatchQuery
     */
    public function getQuery(): BatchQuery
    {
        return $this->query;
    }

    /**
     * Check more data can be fetched
     *
     * @return bool
     */
    public function hasNext(): bool
    {
        return (bool)($this->response['result']['result_next'] ?? []);
    }

    /**
     * Execute next query
     *
     * @param array $startMap
     * @return BatchQueryResult
     */
    public function next(array $startMap = []): BatchQueryResult
    {
        if (!$this->hasNext()) {
            return $this;
        }

        if (!$startMap) {
            $responseNextMap = $this->getResponse()['result']['result_next'] ?? [];

            foreach ($responseNextMap as $key => $start) {
                $startMap[$key] = $start;
            }
        }

        if (!$startMap) {
            return $this;
        }

        foreach ($startMap as $key => $start) {
            $query = $this->query->getQueryList()[$key];

            $query->setPayloadField('start', $start);
        }

        return $this->executor->executeBatchQuery($this->query);
    }
}

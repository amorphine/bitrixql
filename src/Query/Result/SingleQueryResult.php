<?php

namespace Amorphine\BitrixRestQl\Query\Result;

use Amorphine\BitrixRestQl\Query\Result\QueryResult;

class SingleQueryResult extends QueryResult
{
    /**
     * @return int|string
     */
    public function getNext() {
        return $this->response['next'] ?? 0;
    }

    /**
     * @return array<mixed>
     */
    public function getResult() {
        return $this->response['result'] ?? [];
    }

    /**
     * @return int
     */
    public function getTotal() {
        return $this->response['total'] ?? 0;
    }

    /**
     * @return array{start: float, finish: float, duration: float, processing: float, date_start: string, date_finish: string}
     */
    public function getTime() {
        return $this->response['time'];
    }

    /**
     * Execute next query
     *
     * @param int $start
     * @return SingleQueryResult
     */
    public function next(int $start = 0): SingleQueryResult
    {
        if (!$start) {
            $start = $this->getNext();
        }

        $this->query->setPayloadField('start', $start);

        return $this->executor->executeQuery($this->query);
    }
}

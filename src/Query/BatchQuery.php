<?php

namespace Amorphine\BitrixRestQl\Query;

class BatchQuery extends Query
{
    /**
     * @var array<Query>
     */
    private array $queryList = [];

    private bool $halt = false;

    public function __construct()
    {
        parent::__construct('batch', []);
    }

    /**
     * @return Query[]
     */
    public function getQueryList(): array
    {
        return $this->queryList;
    }

    /**
     * @param Query[] $queryList
     */
    public function setQueryList(array $queryList): void
    {
        $this->queryList = $queryList;
    }

    public function appendQuery(string $key, Query $query)
    {
        $this->queryList[$key] = $query;
    }

    /**
     * @return bool
     */
    public function isHalt(): bool
    {
        return $this->halt;
    }

    /**
     * @param bool $halt
     */
    public function setHalt(bool $halt): void
    {
        $this->halt = $halt;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        $cmd = [];

        foreach ($this->getQueryList() as $key => $query) {
            $cmd[$key] =  $query->getMethod() . '?' . http_build_query($query->getPayload());
        }

        return [
            'halt' => $this->isHalt(),
            'cmd' => $cmd,
        ];
    }
}

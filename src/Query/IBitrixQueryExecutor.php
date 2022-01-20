<?php

namespace Amorphine\BitrixRestQl\Query;

use Amorphine\BitrixRestQl\Query\Result\BatchQueryResult;
use Amorphine\BitrixRestQl\Query\Result\SingleQueryResult;
use application\libraries\exceptions\bitrix\BitrixCallConnectionException;
use application\libraries\exceptions\bitrix\BitrixCallProcessedException;

interface IBitrixQueryExecutor
{
    /**
     * @param Query $query
     * @return SingleQueryResult
     *
     * @throws BitrixCallConnectionException|BitrixCallProcessedException
     */
    public function executeQuery(Query $query): SingleQueryResult;

    /**
     * @param BatchQuery $query
     * @return BatchQueryResult
     *
     * @throws BitrixCallConnectionException|BitrixCallProcessedException
     */
    public function executeBatchQuery(BatchQuery $query): BatchQueryResult;
}

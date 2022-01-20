<?php

namespace Amorphine\BitrixRestQl\Query;

use Amorphine\BitrixRestQl\Exceptions\ConnectionException;
use Amorphine\BitrixRestQl\Query\Result\BatchQueryResult;
use Amorphine\BitrixRestQl\Query\Result\SingleQueryResult;

class BitrixQueryExecutor implements IBitrixQueryExecutor
{
    private $url;

    private $userId;

    private $key;

    /**
     * @param $url
     * @param $userId
     * @param $key
     */
    public function __construct($url, $userId, $key)
    {
        $this->url = $url;
        $this->userId = $userId;
        $this->key = $key;
    }

    /**
     * @param Query $query
     * @return SingleQueryResult
     */
    public function executeQuery(Query $query): SingleQueryResult
    {
        $queryResult = $this->call($query->getMethod(), $query->getPayload());

        return new SingleQueryResult($queryResult, $query, $this);
    }

    /**
     * @param array $queries
     * @return BatchQueryResult
     */
    public function executeMultipleQueries(array $queries): BatchQueryResult
    {
        $query = new BatchQuery();

        foreach ($queries as $i => $q) {
            $query->appendQuery($i, $q);
        }

        return $this->executeBatchQuery($query);
    }

    /**
     * @param BatchQuery $query
     * @return BatchQueryResult
     */
    public function executeBatchQuery(BatchQuery $query): BatchQueryResult
    {
        $queryResult = $this->executeQuery($query);

        return new BatchQueryResult($queryResult->getResponse(), $query, $this);
    }

    /**
     *
     *
     * @param $method
     * @param $params
     *
     * @return mixed
     *
     * @throws ConnectionException
     */
    private function call($method, $params)
    {
        $curl = curl_init();

        $queryData = json_encode($params);

        $url = "$this->url/rest/" . ($this->userId) . "/" . ($this->key) . "/" . $method . ".json";

        curl_setopt_array($curl, array(
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_POST => 1,
            CURLOPT_HEADER => 0,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_POSTFIELDS => $queryData,
            CURLOPT_HTTPHEADER => [
                'Content-Type:application/json',
                'Content-Length: ' . strlen($queryData)
            ]
        ));

        $content = curl_exec($curl);

        $curlError = curl_errno($curl);

        $httpCode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);

        if ($content === false && ($curlError || $httpCode > 400)) {
            throw new ConnectionException(
                'Curl Content = false. Curl error' . curl_errno($curl),
                $httpCode,
                curl_errno($curl)
            );
        }

        curl_close($curl);

        $content = @json_decode($content, 1);

        // if (isset($content['error'])) {
        //     throw new BitrixCallProcessedException($content);
        // }

        return $content;
    }
}

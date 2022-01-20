<?php

namespace Amorphine\BitrixRestQl\Query;


class Query
{
    private string $method;

    private array $payload;

    /**
     * @param string $method
     * @param array $payload
     */
    public function __construct(string $method, array $payload = [])
    {
        $this->method = $method;
        $this->payload = $payload;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return $this->payload;
    }

    /**
     * @param array $payload
     */
    public function setPayload(array $payload): void
    {
        $this->payload = $payload;
    }

    /**
     * Set payload field
     *
     * @param string $key
     * @param mixed $data
     */
    public function setPayloadField(string $key, $data): void
    {
        $this->payload[$key] = $data;
    }
}

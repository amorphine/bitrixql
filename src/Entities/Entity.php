<?php

namespace Amorphine\BitrixRestQl\Entities;

abstract class Entity
{
    public $casts = [];

    protected array $attributeMap = [];

    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->mergeData($data);
    }

    /**
     * @return array
     */
    public function getAttributeMap(): array
    {
        return $this->attributeMap;
    }

    /**
     * @param array $attributeMap
     */
    public function setAttributeMap(array $attributeMap): void
    {
        $this->attributeMap = $attributeMap;
    }

    /**
     * @param string $attributeName
     * @return string|null
     */
    protected function getDataKeyByAttributeName(string $attributeName)
    {
        return $this->attributeMap[$attributeName] ?? null;
    }

    /**
     * @param string $attributeName
     * @return mixed|null
     */
    protected function getAttribute(string $attributeName)
    {
        return $this->data[$attributeName] ?? null;
    }

    /**
     * Merge data into entity
     *
     * @param $data
     * @return void
     */
    public function mergeData($data) {
        $this->data = $data;

        $fieldsToCast = array_filter($data, function ($datum, $name) {
            return isset($this->casts[$name]);
        }, ARRAY_FILTER_USE_BOTH);

        foreach ($fieldsToCast as $key => $type) {
            if (!class_exists($type)) {
                continue;
            }

            // TODO implement casting to scalar values
            $data[$key] = new $type($data[$key]);
        }
    }

    public function __get($name)
    {
        $dataName = $this->getDataKeyByAttributeName($name);

        if ($dataName) {
            return $this->data[$dataName] ?? null;
        }

        return $this->data[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $dataToMerge = $this->data;

        $dataName = $this->getDataKeyByAttributeName($name);

        if ($dataName) {
            $dataToMerge[$dataName] = $value;
        } else {
            $dataToMerge[$name] = $value;
        }

        $this->mergeData($dataToMerge);
    }
}

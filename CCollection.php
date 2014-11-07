<?php

class CCollection extends CMap
{
    const SORT_ASC = 0;
    const SORT_DESC = 1;

    protected function create($data = null)
    {
        return new static($data);
    }

    /**
     * Pushes value at the end of the collection
     *
     * @param $value
     * @throws CException
     */
    public function push($value)
    {
        $key = $this->count() - 1;
        $this->add($key, $value);
    }

    /**
     * Generates new collection containing $valueField as key and
     * $textField as value. Optionally data can be grouped by $groupField key
     *
     * @see CHtml::listData
     * @param string|callable $valueField Field which will be used as key
     * @param string|callable $textField Field which will be used as value
     * @param string|callable $groupField Field which will be used as grouping key
     * @return CCollection
     */
    public function lists($valueField, $textField, $groupField = '')
    {
        $result = CHtml::listData($this, $valueField, $textField, $groupField);

        return $this->create($result);
    }

    /**
     * Groups collection data by given field value Accepts CHtml::value
     * format (dot separated subproperties).
     *
     * @see CHtml::value
     * @param string $field Field name which will be used as grouping key
     * @return CCollection
     */
    public function groupBy($field)
    {
        $data = $this->toArray();
        $result = array();

        foreach ($data as $element) {
            $groupKey = CHtml::value($element, $field);

            if (!isset($result[$groupKey])) {
                $result[$groupKey] = $this->create();
            }

            $result[$groupKey][] = $element;
        }

        return new self($result);
    }

    /**
     * Maps collection elements to new collection using
     * given callback for each element
     *
     * @see array_map
     * @param callable $callback
     * @return CCollection
     */
    public function map($callback)
    {
        $result = array_map($callback, $this);

        return $this->create($result);
    }

    /**
     * Reducts collection values to single value using
     * given callback
     *
     * @see array_reduce
     * @param callable $callback
     * @return mixed
     */
    public function reduce($callback)
    {
        return array_reduce($this, $callback);
    }

    /**
     * Filters collection using given callback
     *
     * @see array_filter
     * @param callable $callback
     * @return CCollection
     */
    public function filter($callback)
    {
        $result = array_filter($this->toArray(), $callback);

        return $this->create($result);
    }

    /**
     * Filters by given field value. Accepts CHtml::value
     * format (dot separated subproperties).
     *
     * @see CHtml::value
     * @param string $field
     * @param string $value
     */
    public function filterBy($field, $value)
    {
        return $this->filter(function($element) use ($field, $value) {
            return CHtml::value($element, $field)=== $value;
        });
    }

    /**
     * Sorts collection using given callback
     *
     * @see uasort
     * @param callable $callback
     * @return CCollection
     */
    public function sort($callback)
    {
        $data = $this->toArray();

        uasort($data, $callback);

        return $this->create($data);
    }

    /**
     * Sorts collection by field name Accepts CHtml::value
     * format (dot separated subproperties).
     *
     * @see CHtml::value
     * @param string $field
     * @param int $direction Sort direction (self::SORT_ASC or self::SORT_DESC)
     * @return CCollection
     */
    public function sortBy($field, $direction = self::SORT_ASC)
    {
        $result = array();
        $fieldValues = array();
        $data = $this->toArray();

        foreach ($data as $key => $item) {
            $fieldValues[$key] = CHtml::value($item, $field);
        }

        if ($direction === self::SORT_ASC) {
            asort($fieldValues, SORT_REGULAR);
        } else {
            arsort($fieldValues, SORT_REGULAR);
        }

        foreach (array_keys($fieldValues) as $key) {
            $result[$key] = $data[$key];
        }

        return $this->create($result);
    }
}
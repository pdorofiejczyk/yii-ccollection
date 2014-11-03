<?php

class CCollectableActiveRecord extends CActiveRecord
{
    public $collectionClass = 'CList';

    public function createCollection($records)
    {
        $className = $this->collectionClass;

        return new $className($records);
    }

    public function populateRecords($data, $callAfterFind = true, $index = null)
    {
        $records = parent::populateRecords($data, $callAfterFind = true, $index = null);

        return $this->createCollection($records);
    }
}
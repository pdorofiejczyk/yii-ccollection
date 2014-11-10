<?php

class CCollectableActiveRecord extends CActiveRecord
{
    public $collectionClass = 'CModelCollection';

    /**
     * Creates new collection with containing given records.
     *
     * @param array $records Records to be added to new collection
     * @return CModelCollection
     */
    public function createCollection($records)
    {
        $className = $this->collectionClass;

        return new $className(__CLASS__, $records);
    }

    public function populateRecords($data, $callAfterFind = true, $index = null)
    {
        $records = parent::populateRecords($data, $callAfterFind = true, $index = null);

        return $this->createCollection($records);
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
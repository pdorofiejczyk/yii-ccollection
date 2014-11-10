<?php
include(dirname(__FILE__) . '/../../CCollectableActiveRecord.php');

class Post extends CCollectableActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'tbl_post';
    }
}

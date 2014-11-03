<?php
include(dirname(__FILE__) . '/../../CCollectableActiveRecord.php');

class CollectableUser extends CCollectableActiveRecord
{
    public function tableName()
    {
        return 'users';
    }

    public static function model($class = __CLASS__)
    {
        return parent::model($class);
    }

}

class TestModel extends CModel
{
    public $p1;
    public $p2;
    public $p3;

    public function __construct($attributes = null)
    {
        if ($attributes !== null) {
            $this->setAttributes($attributes, false);
        }
    }

    public function attributeNames()
    {
        return array(
            'p1',
            'p2',
            'p3'
        );
    }
}

class TestChildModel extends TestModel
{

}

class TestNonChildModel extends CModel
{
    public function attributeNames()
    {

    }
}

class TestNonModel
{

}
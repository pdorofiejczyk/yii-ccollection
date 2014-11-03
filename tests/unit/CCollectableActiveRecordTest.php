<?php
include(dirname(__FILE__) . '/../data/models.php');

class CCollectableActiveRecordTest extends CTestCase
{
    private $_connection;

    protected function setUp()
    {
        $this->_connection = new CDbConnection('sqlite::memory:');
        $this->_connection->active = true;
        $this->_connection->pdoInstance->exec(file_get_contents(dirname(__FILE__) . '/../../yii/tests/framework/db/data/sqlite.sql'));
        CCollectableActiveRecord::$db = $this->_connection;
    }

    /**
     * @test
     */
    function populateRecordsEmpty()
    {
        $model = new CollectableUser(null);
        $list = $model->populateRecords(array());

        $this->assertTrue($list instanceof $model->collectionClass);
        $this->assertEmpty($list);
    }

    public function usersDataProvider()
    {
        return array(
            array(
                array(
                    array(
                        'id' => 111,
                        'username' => 'test',
                        'password' => 'dsfdsfsd',
                        'email' => 'sds@dfsdf.ds',
                    ),
                ),
            ),
            array(
                array(
                    array(
                        'id' => 111,
                        'username' => 'test',
                        'password' => 'dsfdsfsd',
                        'email' => 'sds@dfsdf.ds',
                    ),
                    array(
                        'id' => 222,
                        'username' => 'test2',
                        'password' => 'derefsd',
                        'email' => 'iiii@fsd.dd',
                    ),
                ),
            ),
            array(
                array(
                    array(
                        'id' => 111,
                        'username' => 'test',
                        'password' => 'dsfdsfsd',
                        'email' => 'sds@dfsdf.ds',
                    ),
                    array(
                        'id' => 222,
                        'username' => 'test2',
                        'password' => 'derefsd',
                        'email' => 'iiii@fsd.dd',
                    ),
                    array(
                        'id' => 333,
                        'username' => 'test3',
                        'password' => 'ppppp',
                        'email' => 'vvv@lll.dd',
                    ),
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider usersDataProvider
     */
    function populateRecordsNonEmpty($data)
    {
        $model = new CollectableUser(null);

        $list = $model->populateRecords($data);

        $this->assertTrue($list instanceof $model->collectionClass);
        $this->assertCount(count($data), $list);
        $this->assertContainsOnlyInstancesOf('CollectableUser', $list);

        foreach ($list as $k => $element) {
            $this->assertSame($data[$k]['id'], $element->id);
        }
    }
}
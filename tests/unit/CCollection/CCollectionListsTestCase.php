<?php
require_once(dirname(__FILE__) . '/../../../CCollection.php');

class CCollectionListsTestCase extends CTestCase
{
    public function createCollection()
    {
        return new CCollection(array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            ),
            array(
                'p1' => 'bbb',
                'p2' => 222,
                'p3' => true,
            ),
            array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            ),
        ));
    }

    public function dataProvider()
    {
        return array(
            array(
                'p1', null, null,
                array('aaa', 'bbb', 'ccc'),
            ),
            array(
                'p2', null, null,
                array(111, 222, 222),
            ),
            array(
                'p1', 'p2', null,
                array('aaa' => 111, 'bbb' => 222, 'ccc' => 222),
            ),
            array(
                'p2', 'p1', null,
                array(111 => 'aaa', 222 => 'ccc'),
            ),
            array(
                'p3', 'p1', null,
                array(true => 'bbb', false => 'ccc'),
            ),
            array(
                'p1', 'p3', 'p2',
                array(
                    111 => array('aaa' => true),
                    222 => array('bbb' => true, 'ccc' => false),
                ),
            ),
            array(
                'p1', 'p2', 'p3',
                array(
                    true => array('aaa' => 111, 'bbb' => 222),
                    false => array('ccc' => 222),
                ),
            ),
        );
    }

    /**
     * @test
     * @covers       CCollection::lists
     * @dataProvider dataProvider
     */
    public function lists($key, $value, $group, $expected)
    {
        $collection = $this->createCollection();

        $dataList = $collection->lists($key, $value, $group);

        $this->assertEquals(new CCollection($expected), $dataList);
    }
}
<?php
require_once(dirname(__FILE__) . '/../../../CCollection.php');

class CCollectionSortTestCase extends CTestCase
{
    public function createCollection()
    {
        return new CCollection(array(
            array(
                'p1' => 'ccc',
                'p2' => 111,
                'p3' => array('p31' => 200),
            ),
            array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => array('p31' => 300),
            ),
            array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => array('p31' => 100),
            ),
        ));
    }

    public function dataProvider()
    {
        return array(
            array(
                function ($a, $b) {
                    return ($a['p2'] < $b['p2']) ? 1 : -1;
                },
                'p2',
                CCollection::SORT_DESC,
                array(333, 222, 111)
            ),
            array(
                function ($a, $b) {
                    return ($a['p1'] > $b['p1']) ? 1 : -1;
                },
                'p1',
                CCollection::SORT_ASC,
                array('aaa', 'bbb', 'ccc')
            ),
            array(
                function ($a, $b) {
                    return ($a['p3']['p31'] > $b['p3']['p31']) ? 1 : -1;
                },
                'p3.p31',
                CCollection::SORT_ASC,
                array(100, 200, 300)
            ),
        );
    }

    /**
     * @test
     * @covers CCollection::sort
     * @dataProvider dataProvider
     */
    public function sort($callback, $field, $direction, $expected)
    {
        $collection = $this->createCollection();

        $sortedCollection = $collection->sort($callback);

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], CHtml::value($model, $field));
            $i++;
        }
    }

    /**
     * @test
     * @covers CCollection::sortBy
     * @dataProvider dataProvider
     */
    public function sortBy($callback, $field, $direction, $expected)
    {
        $collection = $this->createCollection();

        $sortedCollection = $collection->sortBy($field, $direction);

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], CHtml::value($model, $field));
            $i++;
        }
    }
}
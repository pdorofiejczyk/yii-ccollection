<?php
require_once(dirname(__FILE__) . '/../../../CCollection.php');

class CCollectionFilterTestCase extends CTestCase
{
    public function createCollection()
    {
        return new CCollection(array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => array('p31' => 100),
            ),
            array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => array('p31' => 200),
            ),
            array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => array('p31' => 300),
            ),
        ));
    }

    public function dataProvider()
    {
        return array(
            array(
                'p1',
                'aaa',
                array(
                    0 => array(
                        'p1' => 'aaa',
                        'p2' => 111,
                        'p3' => array('p31' => 100),
                    ),
                    2 => array(
                        'p1' => 'aaa',
                        'p2' => 222,
                        'p3' => array('p31' => 300),
                    ),
                ),
            ),
            array(
                'p2',
                111,
                array(
                    0 => array(
                        'p1' => 'aaa',
                        'p2' => 111,
                        'p3' => array('p31' => 100),
                    ),
                ),
            ),
            array(
                'p3',
                'xxx',
                array(),
            ),
            array(
                'p3.p31',
                100,
                array(
                    array(
                        'p1' => 'aaa',
                        'p2' => 111,
                        'p3' => array('p31' => 100),
                    ),
                ),
            ),
        );
    }

    /**
     * @test
     * @coders CCollection::filter
     * @dataProvider dataProvider
     */
    public function filter($field, $value, $expected)
    {
        $collection = $this->createCollection();
        $expectedCollection = new CCollection($expected);

        $filteredCollection = $collection->filter(function ($model) use ($field, $value) {
            return CHtml::value($model, $field) === $value;
        });

        $this->assertEquals($expectedCollection, $filteredCollection);
    }

    /**
     * @test
     * @coders CCollection::filterBy
     * @dataProvider dataProvider
     */
    public function filterBy($field, $value, $expected)
    {
        $collection = $this->createCollection();
        $expectedCollection = new CCollection($expected);

        $filteredCollection = $collection->filterBy($field, $value);

        $this->assertEquals($expectedCollection, $filteredCollection);
    }
}
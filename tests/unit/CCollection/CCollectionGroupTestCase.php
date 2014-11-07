<?php
require_once(dirname(__FILE__) . '/../../../CCollection.php');

class CCollectionGroupTestCase extends CTestCase
{
    public function createCollection()
    {
        return new CCollection(array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => array('p31' => 111),
            ),
            array(
                'p1' => 'bbb',
                'p2' => 222,
                'p3' => array('p31' => 222),
            ),
            array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => array('p31' => 111),
            ),
        ));
    }

    function groupByDataProvider()
    {
        return array(
            array(
                'p2',
                array(
                    111 => new CCollection(array(
                        array(
                            'p1' => 'aaa',
                            'p2' => 111,
                            'p3' => array('p31' => 111),
                        )
                    )),
                    222 => new CCollection(array(
                        array(
                            'p1' => 'bbb',
                            'p2' => 222,
                            'p3' =>  array('p31' => 222),
                        ),
                        array(
                            'p1' => 'ccc',
                            'p2' => 222,
                            'p3' =>  array('p31' => 111),
                        ),
                    )),
                ),
            ),
            array(
                'p3.p31',
                array(
                    111 => new CCollection(array(
                        array(
                            'p1' => 'aaa',
                            'p2' => 111,
                            'p3' => array('p31' => 111),
                        ),
                        array(
                            'p1' => 'ccc',
                            'p2' => 222,
                            'p3' => array('p31' => 111),
                        ),
                    )),
                    222 => new CCollection(array(
                        array(
                            'p1' => 'bbb',
                            'p2' => 222,
                            'p3' => array('p31' => 222),
                        ),
                    )),
                ),
            ),
        );
    }

    /**
     * @test
     * @covers CCollection::groupBy
     * @dataProvider groupByDataProvider
     */
    public function groupBy($field, $expected)
    {
        $collection = $this->createCollection();

        $groupedCollection = $collection->groupBy($field);

        $this->assertEquals(new CCollection($expected), $groupedCollection);
    }
}
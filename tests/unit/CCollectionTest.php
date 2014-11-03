<?php
require_once(dirname(__FILE__) . '/../../CCollection.php');
require_once(dirname(__FILE__) . '/../data/models.php');

class CCollectionTest extends CTestCase
{

    public function models()
    {
        return array(
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
        );
    }

    public function modelsDataProvider()
    {
        return array(
            array($this->models())
        );
    }

    public function listsDataProvider()
    {
        $models = $this->models();

        return array(
            array(
                $models,
                'p1',
                'p2',
                array('aaa' => 111, 'bbb' => 222, 'ccc' => 222),
            ),
            array(
                $models,
                'p2',
                'p1',
                array(111 => 'aaa', 222 => 'ccc'),
            ),
            array(
                $models,
                'p3',
                'p1',
                array(true => 'bbb', false => 'ccc'),
            ),
        );
    }

    /**
     * @test
     * @dataProvider listsDataProvider
     */
    public function lists($models, $key, $value, $expected)
    {
        $collection = new CCollection($models);

        $dataList = $collection->lists($key, $value);

        $this->assertEquals(new CCollection($expected), $dataList);
    }

    public function listsGroupsDataProvider()
    {
        $models = $this->models();

        return array(
            array(
                $models,
                'p1',
                'p3',
                'p2',
                array(
                    111 => array('aaa' => true),
                    222 => array('bbb' => true, 'ccc' => false),
                ),
            ),
            array(
                $models,
                'p1',
                'p2',
                'p3',
                array(
                    true => array('aaa' => 111, 'bbb' => 222),
                    false => array('ccc' => 222),
                ),
            ),
        );
    }

    /**
     * @test
     * @dataProvider listsGroupsDataProvider
     */
    public function listsWithGroups($models, $key, $value, $group, $expected)
    {
        $collection = new CCollection($models);

        $dataList = $collection->lists($key, $value, $group);

        $this->assertEquals(new CCollection($expected), $dataList);
    }

    /**
     * @test
     */
    public function groupBy()
    {
        $models = array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            ),
            array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            ),
            array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            ),
        );

        $expected = array(
            'aaa' => new CCollection(array(
                0 => array(
                    'p1' => 'aaa',
                    'p2' => 111,
                    'p3' => true,
                ),
                2 => array(
                    'p1' => 'aaa',
                    'p2' => 222,
                    'p3' => false,
                ),
            )),
            'bbb' => new CCollection(array(
                1 => array(
                    'p1' => 'bbb',
                    'p2' => 333,
                    'p3' => true,
                ),
            )),
        );

        $collection = new CCollection($models);

        $groupedCollection = $collection->groupBy('p1');

        $this->assertEquals(new CCollection($expected), $groupedCollection);
    }

    /**
     * @test
     */
    public function sort()
    {
        $models = array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            ),
            array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            ),
            array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            ),
        );

        $expected = array(333, 222, 111);

        $collection = new CCollection($models);

        $sortedCollection = $collection->sort(function ($a, $b) {
            return ($a['p2'] < $b['p2']) ? 1 : -1;
        });

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], $model['p2']);
            $i++;
        }
    }

    /**
     * @test
     */
    public function sortByNumeric()
    {
        $models = array(
            array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            ),
            array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            ),
            array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            ),
        );

        $expected = new CCollection(array(111, 222, 333));
        $collection = new CCollection($models);

        $sortedCollection = $collection->sortBy('p2', CCollection::SORT_ASC);

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], $model['p2']);
            $i++;
        }
    }

    /**
     * @test
     */
    public function sortByAlpha()
    {
        $models = array(
            array(
                'p1' => 'bbb',
                'p2' => 111,
                'p3' => true,
            ),
            array(
                'p1' => 'aaa',
                'p2' => 333,
                'p3' => true,
            ),
            array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            ),
        );

        $expected = new CCollection(array('ccc', 'bbb', 'aaa'));
        $collection = new CCollection($models);

        $sortedCollection = $collection->sortBy('p1', CCollection::SORT_DESC);

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], $model['p1']);
            $i++;
        }
    }
}
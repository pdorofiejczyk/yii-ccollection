<?php
require_once(dirname(__FILE__) . '/../../CCollection.php');
require_once(dirname(__FILE__) . '/../../CModelCollection.php');
require_once(dirname(__FILE__) . '/../data/models.php');

class CModelCollectionTest extends CTestCase
{
    public function typeDataProvider()
    {
        return array(
            array('CModel', true),
            array('TestModel', true),
            array('TestChildModel', true),
            array('TestNonModel', false),
        );
    }

    /**
     * @test
     * @dataProvider typeDataProvider
     */
    public function constructWithType($type, $expected)
    {
        try {
            new CModelCollection($type);
            $result = true;
        } catch (CException $e) {
            $result = false;
        }

        $this->assertEquals($expected, $result);
    }

    public function modelDataProvider()
    {
        return array(
            array(null, new TestModel, true),
            array(null, new TestChildModel, true),
            array(null, new TestNonChildModel, true),
            array(null, new TestNonModel, false),
            array('TestModel', new TestModel, true),
            array('TestModel', new TestChildModel, true),
            array('TestModel', new TestNonChildModel, false),
            array('TestModel', new TestNonModel, false),
            array('TestChildModel', new TestModel, false),
            array('TestChildModel', new TestChildModel, true),
            array('TestChildModel', new TestNonChildModel, false),
            array('TestChildModel', new TestNonModel, false),
        );
    }

    /**
     * @test
     * @dataProvider modelDataProvider
     */
    public function push($type, $model, $expected)
    {
        if ($type === null) {
            $collection = new CModelCollection();
        } else {
            $collection = new CModelCollection($type);
        }

        try {
            $collection->push($model);
            $result = true;
        } catch (CException $e) {
            $result = false;
        }

        $this->assertEquals($expected, $result);
    }


    public function models()
    {
        return array(
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'bbb',
                'p2' => 222,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            )),
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

    /**
     * @test
     */
    public function groupBy()
    {
        $models = array(
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $expected = array(
            'aaa' => new CCollection(array(
                0 => new TestModel(array(
                    'p1' => 'aaa',
                    'p2' => 111,
                    'p3' => true,
                )),
                1 => new TestModel(array(
                    'p1' => 'aaa',
                    'p2' => 222,
                    'p3' => false,
                )),
            )),
            'bbb' => new CCollection(array(
                0 => new TestModel(array(
                    'p1' => 'bbb',
                    'p2' => 333,
                    'p3' => true,
                )),
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
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'ccc',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $expected = array(333, 222, 111);

        $collection = new CCollection($models);

        $sortedCollection = $collection->sort(function ($a, $b) {
            return ($a->p2 < $b->p2) ? 1 : -1;
        });

        $i = 0;
        foreach ($sortedCollection as $id => $model) {
            $this->assertEquals($expected[$i], $model->p2);
            $i++;
        }
    }

    /**
     * @test
     */
    public function filter()
    {
        $models = array(
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $expected = array(
            0 => new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            2 => new TestModel(array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $collection = new CCollection($models);
        $expectedCollection = new CCollection($expected);

        $filteredCollection = $collection->filter(function($element) {
            return $element->p1 === 'aaa';
        });

        $this->assertEquals($expectedCollection, $filteredCollection);
    }

    /**
     * @test
     */
    public function filterBy()
    {
        $models = array(
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'bbb',
                'p2' => 333,
                'p3' => true,
            )),
            new TestModel(array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $expected = array(
            0 => new TestModel(array(
                'p1' => 'aaa',
                'p2' => 111,
                'p3' => true,
            )),
            2 => new TestModel(array(
                'p1' => 'aaa',
                'p2' => 222,
                'p3' => false,
            )),
        );

        $collection = new CCollection($models);
        $expectedCollection = new CCollection($expected);

        $filteredCollection = $collection->filterBy('p1', 'aaa');

        $this->assertEquals($expectedCollection, $filteredCollection);
    }
}
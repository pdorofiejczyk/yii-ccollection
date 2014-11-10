<?php
require_once(dirname(__FILE__) . '/../../CCollection.php');
require_once(dirname(__FILE__) . '/../../CModelCollection.php');
require_once(dirname(__FILE__) . '/../data/models2.php');

class CCollectableActiveRecordIntegratonTest extends CDbTestCase
{
    public $fixtures = array(
        'posts' => 'Post',
    );

    /**
     * @test
     */
    public function model()
    {
        $model = Post::model();

        $this->assertTrue($model instanceof CCollectableActiveRecord);
        $this->assertTrue($model instanceof CActiveRecord);
    }

    /**
     * @test
     */
    public function findAll()
    {
        $posts = Post::model()->findAll();

        $this->assertTrue($posts instanceof CModelCollection);
        $this->assertContainsOnlyInstancesOf('Post', $posts);
        $this->assertCount(count($this->posts), $posts);
    }

    /**
     * @test
     */
    public function findAllCondition()
    {
        $posts = Post::model()->findAll('author_id = :authorId', array('authorId' => 2));

        $this->assertTrue($posts instanceof CModelCollection);
        $this->assertContainsOnlyInstancesOf('Post', $posts);
        $this->assertCount(2, $posts);
    }

    /**
     * @test
     */
    public function findAllEmpty()
    {
        $posts = Post::model()->find('author_id = :authorId', array('authorId' => 3));

        $this->assertEquals(null, $posts);
    }

    /**
     * @test
     */
    public function find()
    {
        $post = Post::model()->find('author_id = :authorId', array('authorId' => 1));

        $this->assertTrue($post instanceof Post);
    }

    /**
     * @test
     */
    public function findByAttributes()
    {
        $post = Post::model()->findByAttributes(array(
            'author_id' => 1
        ));

        $this->assertTrue($post instanceof Post);
    }
}
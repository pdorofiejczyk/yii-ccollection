Missing Yii CCollection
=======================

Yii has collection classes like CMap or CList but it doesn't provides methods for operations on these collections. CCollection fills this gap.

What's more, Yii CActiveRecord always return array of models instead of returning collection which can ease operations on data retrieved from database. Models based on CCollectableActiveRecord returns CModelCollection which has special methods for dealing with collection of Models.
 
Examples
--------
 
Post.php
```
class Post extends CCollectableActiveRecord
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function tableName()
    {
        return 'posts';
    }
    
    public function relations()
    {
        return array(
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
        )
    }
}
```

Usage
```
$posts = Post::model()->findAll();

$postsCount = $posts->count();

$postsGroupedByAuthor = $posts->groupBy('author_id');

$myPostsCount = $posts->filterBy('author_id', $currentUser->id);

$postsAuthorNames = $posts->lists('id', 'author.name');

$criteria = new CDbCriteria();
$criteria->addInCondition('id', $posts->lists('author_id'));
$allAuthors = User::model()->findAll($criteria);
```
 

API reference
-------------

###CCollection (extends CModel)

####lists()

<table>
    <tr><td colspan="3">public CCollection lists($keyField, $valueField = null, $groupField = null)</td></tr>
    <tr><td>$keyField</td><td>string | callable</td><td>Field which will be used as key or value when $valueField is null</td></tr>
    <tr><td>$valueField</td><td>string | callable | null</td><td>Field which will be used as value (optional)</td></tr>
    <tr><td>$groupField</td><td>string | callable | null</td><td>Field which will be used as grouping key (optional)</td></tr>
</table>

Generates new associative collection containing $keyField as key and $valueField as value or non-associative collection with $keyField as value when $valueField is null. Optionally data can be grouped by $groupField key

####groupBy()

<table>
    <tr><td colspan="3">public CCollection groupBy($field)</td></tr>
    <tr><td>$field</td><td>string</td><td>Field name which will be used as grouping key</td></tr>
</table>

Groups collection data by given field value. Accepts CHtml::value format (dot separated properties) to access nested elements.

####map()

<table>
    <tr><td colspan="3">public CCollection map($callback)</td></tr>
    <tr><td>$callback</td><td>callable</td><td>Callback function to run for each element in each collection element.</td></tr>
</table>

Maps collection elements to new collection using given callback for each element

####reduce()

<table>
    <tr><td colspan="3">public mixed reduce($callback)</td></tr>
    <tr><td>$callback</td><td>callable</td><td>Callback function to run for each element in each collection element.</td></tr>
</table>

Reducts collection values to single value using given callback

####filter()

<table>
    <tr><td colspan="3">public CCollection filter($callback)</td></tr>
    <tr><td>$callback</td><td>callable</td><td>Callback function to run for each element in each collection.</td></tr>
</table>

Filters collection using given callback

####filterBy()

<table>
    <tr><td colspan="3">public CCollection filterBy($field, $value)</td></tr>
    <tr><td>$field</td><td>string</td><td>Name of field which value will be used for filtering</td></tr>
    <tr><td>$value</td><td>mixed</td><td>Value which will be compared with $field value</td></tr>
</table>

Filters by given field value. Accepts CHtml::value format (dot separated properties) to access nested elements.

####sort()

<table>
    <tr><td colspan="3">public CCollection sort($callback)</td></tr>
    <tr><td>$callback</td><td>callable</td><td>Callback function to run for each element in each collection.</td></tr>
</table>

Sorts collection using given callback

####sortBy()

<table>
    <tr><td colspan="3">public CCollection sortBy($field, $direction = self::SORT_ASC)</td></tr>
    <tr><td>$field</td><td>string</td><td>Field which will be used for sorting.</td></tr>
    <tr><td>$direction</td><td>string</td><td>Sort direction (self::SORT_ASC or self::SORT_DESC)</td></tr>
</table>

Sorts collection by field name. Accepts CHtml::value format (dot separated properties) to access nested elements.

###CModelCollection (extends CCollection)

####__construct()

<table>
    <tr><td colspan="3">public void __construct($type = 'CModel', $models = null, $readOnly = false)</td></tr>
    <tr><td>$type</td><td>string</td><td>Type of containing elements</td></tr>
    <tr><td>$models</td><td>array | null</td><td>Array of models to be added to new collection (optional)</td></tr>
    <tr><td>$readOnly</td><td>boolean</td><td>If model is read-only</td></tr>
</table>

###CCollectableActiveRecord (extends CActiveRecord)

####createCollection()

<table>
    <tr><td colspan="3">public CModelCollection createCollection($records)</td></tr>
    <tr><td>$records</td><td>array</td><td>Type of containing elements</td></tr>
</table>

Creates new collection with containing given records.
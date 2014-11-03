Missing Yii CCollection
=======================

Yii has collection classes like CMap or CList but it doesn't provides methods for operations on these collections. [CCollection](docs/CCollection.md) fills this gap.

What's more, Yii CActiveRecord always return array of models instead of returning collection which can ease operations on data retrieved from database. Models based on CCollectableActiveRecord returns CModelCollection which has special methods for dealing with collection of Models.
 
Examples
--------
 
```
$posts = Post::model()->findAll();

$postsCount = $posts->count();

$postsGroupedByAuthor = $posts->groupBy('author_id');

$myPostsCount = $posts->filter(function($post) use ($currentUser) {
    return $post->author_id === $currentUser->id;
})->count();
```
 

[API docs](docs/ApiIndex.md)

Work in progress...
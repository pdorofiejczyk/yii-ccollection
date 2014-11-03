CCollection
===============






* Class name: CCollection
* Namespace: 
* Parent class: CMap



Constants
----------


### SORT_ASC

```
const SORT_ASC = 0
```





### SORT_DESC

```
const SORT_DESC = 1
```







Methods
-------


### \CCollection::create()

```
mixed CCollection::\CCollection::create()($data)
```





* Visibility: **protected**

#### Arguments

* $data **mixed**



### \CCollection::push()

```
mixed CCollection::\CCollection::push()($value)
```

Pushes value at the end of the collection



* Visibility: **public**

#### Arguments

* $value **mixed**



### \CCollection::lists()

```
\CCollection CCollection::\CCollection::lists()(string|callable $valueField, string|callable $textField, string|callable $groupField)
```

Generates new collection containing $valueField as key and
$textField as value. Optionally data can be grouped by $groupField key



* Visibility: **public**

#### Arguments

* $valueField **string|callable** - &lt;p&gt;Field which will be used as key&lt;/p&gt;
* $textField **string|callable** - &lt;p&gt;Field which will be used as value&lt;/p&gt;
* $groupField **string|callable** - &lt;p&gt;Field which will be used as grouping key&lt;/p&gt;



### \CCollection::groupBy()

```
\CCollection CCollection::\CCollection::groupBy()(string $field)
```

Groups collection data by given field value



* Visibility: **public**

#### Arguments

* $field **string** - &lt;p&gt;Field name which will be used as grouping key&lt;/p&gt;



### \CCollection::map()

```
\CCollection CCollection::\CCollection::map()(callable $callback)
```

Maps collection elements to new collection using
given callback for each element



* Visibility: **public**

#### Arguments

* $callback **callable**



### \CCollection::reduce()

```
mixed CCollection::\CCollection::reduce()(callable $callback)
```

Reducts collection values to single value using
given callback



* Visibility: **public**

#### Arguments

* $callback **callable**



### \CCollection::filter()

```
\CCollection CCollection::\CCollection::filter()(callable $callback)
```

Filters collection using given callback



* Visibility: **public**

#### Arguments

* $callback **callable**



### \CCollection::sort()

```
\CCollection CCollection::\CCollection::sort()(callable $callback)
```

Sorts collection using given callback



* Visibility: **public**

#### Arguments

* $callback **callable**



### \CCollection::sortBy()

```
\CCollection CCollection::\CCollection::sortBy()(string $field, integer $direction)
```

Sorts collection by field name



* Visibility: **public**

#### Arguments

* $field **string**
* $direction **integer** - &lt;p&gt;Sort direction (self::SORT_ASC or self::SORT_DESC)&lt;/p&gt;



# findinset_relation
Set eloquent relationships with table that contains comma separated values as a foreign key

# Installation
Get package using composer  :

`composer require ghanuz/relations`

# 1.
You have to extends `GhanuZ\Model` class instead of `Illuminate\Database\Eloquent\Model`

```
<?php

namespace App;

use GhanuZ\Model;

class Test extends Model
{
    //
}
```
## You can also use traits instead of extend Model class 
Like in Laravel, `Users` model not extending `Model` class.
So you can use `trait`.
`GhanuZ\FindInSet\FindInSetRelationTrait`

Example:
```
<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GhanuZ\FindInSet\FindInSetRelationTrait;

class User extends Authenticatable
{
    use Notifiable, FindInSetRelationTrait;

    public function city ()
    {
        return $this->FindInSetOne( 'App\City', 'city_ids', 'id', 1);
    }

    public function state ()
    {
        return $this->FindInSetOne( 'App\State', 'city_ids', 'id', 2);
    }

    public function country ()
    {
        return $this->FindInSetOne( 'App\Country', 'city_ids', 'id', 3);
    }

    public function hobbies ()
    {
        return $this->FindInSetMany( 'App\Hobbies', 'hobbies_id', 'id');
    }

}
```

## To create `HasMany` Relation you have to write as :

```
public function order_product (){
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY);
}
```

## To create `HasOne` Relation you have to write as :

```
public function order_product (){
    return $this->FindInSetOne( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY);
}
```

## You can also pass 4th argumaent to detect position in FIND_IN_SET :
If you have an `address` table schema and stored `city_ids` like `city_id,state_id,country_id`.


Now, you want to find only `city_id`, you will do as :
`select * from address where FIND_IN_CITY( 2, city_ids ) = 1;// Here $index = 1` 

Like, for `state_id`:
`select * from address where FIND_IN_CITY( 1, city_ids ) = 2;// Here $index = 2`

Like, for `country_id`:
`select * from address where FIND_IN_CITY( 5, city_ids ) = 3;// Here $index = 3`

## 4th argument is optional 
```
public function order_product (){
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number);
}
```

## 5th Argument related to JSON

This 5th argument is optional. When you have a JSON string in field and want to apply the relation on the specific field of your JSON object then you have to define the `field` name of the JSON string using this argument.

[Detailed Explanation](#json-support--v35-)

## Added support of Array cast from version v3.

From version v3, you can also use custom casting provided by the Laravel framework to manipulate comma deligated value into array. If you are using casts of Laravel to convert the string with comma value into Array then this package also support it to retrive the related table data.

### Example

```

/**
* The attributes that should be cast.
*
* @var array<string, string>
*/
protected $casts = [
    'FIELD' => CUSTOM_CLASS::class,
];


/**
*
* To retrive array of relational tables 
*
*/
public function order_products ()
{
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number);
}

/**
*
* To retrive single data of the relational table
*
*/
public function order_product ()
{
    return $this->FindInSetOne( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number);
}
```

# Json Support ( V3.5 )

Now this package can also handle specific field from the `JSON` field that can be converted into `array` using the `cast` feature of the Laravel.

### JSON string in your database

```
// Field Name: json_field
[
  {
    "id": "1",
    "name": "One"
  },
  {
    "id": "1",
    "name": "Two"
  }
]

```
And another JSON like:

```
// Field Name: json_field
[
  {
    "id": "1,2",
    "name": "One and two"
  },
  {
    "id": "3,4,5",
    "name": "Three, Four and Five"
  }
]

```
## To create `HasMany` Relation with JSON field you have to write as :

Where `JSON_FIELD_NAME` will be `id` as per above JSON value.

```
public function order_product (){
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, JSON_FIELD_NAME);
}
```

## To create `HasOne` Relation you have to write as :

```
public function order_product (){
    return $this->FindInSetOne( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, JSON_FIELD_NAME));
}
```
Then you can load relation with the `id` field of this JSON string using following:


Model.php
```

/**
* The attributes that should be cast.
*
* @var array<string, string>
*/
protected $casts = [
    'json_field' => 'array',
];


/**
*
* To retrive array of relational tables with the JSON field
*
*/
public function order_products ()
{
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number, 'id');
}

/**
*
* To retrive single data of the relational table with the JSON field
*
*/
public function order_product ()
{
    return $this->FindInSetOne( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number, 'id');
}
```

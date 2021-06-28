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

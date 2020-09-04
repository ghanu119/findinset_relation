# findinset_relation
Set eloquent relationships with table that contains comma separated values as a foreign key

# 1.
You have to extends `GhanuZ\Model` class instead of `Illuminate\Database\Eloquent\Model`

`
<?php

namespace App;

use GhanuZ\Model;

class Test extends Model
{
    //
}

`

# 2. To create `HasMany` Relation you have to write as :

`
public function order_product (){
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY);
}
`

# 3. You can also pass 4th argumaent to detect position in FIND_IN_SET :
If you have an `address` table schema and stored `city_ids` like `city_id,state_id,country_id`.


Now, you want to find only `city_id`, you will do as :
`select * from address where FIND_IN_CITY( 2, city_ids ) = 1;// Here $index = 1` 

Like, for `state_id`:
`select * from address where FIND_IN_CITY( 1, city_ids ) = 2;// Here $index = 2`

Like, for `country_id`:
`select * from address where FIND_IN_CITY( 5, city_ids ) = 3;// Here $index = 3`

## 4th argument is optional 
`
public function order_product (){
    return $this->FindInSetMany( CLASS_NAME, FOREIGN_KEY, LOCAL_KEY, Number);
}
`
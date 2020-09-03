<?php

namespace GhanuZ\Relations;

use Illuminate\Database\Eloquent\Model as LaravelModel;
use GhanuZ\Relations\FindInSet\FindInSetRelationTrait;

class Model extends LaravelModel {
    use FindInSetRelationTrait;
}

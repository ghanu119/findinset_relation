<?php
namespace GhanuZ\Relations\FindInSet;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class FindInSetRelation extends HasMany{

    private $index;

    public function __construct(Builder $query, Model $parent, $foreignKey, $localKey, $index = null){
        $this->index = $index;

        parent::__construct($query, $parent, $foreignKey, $localKey);
    }
    
    /**
     * Set the base constraints on the relation query.
     *
     * @return void
     */
    public function addConstraints()
    {
        if (static::$constraints) {
            if( is_null( $this->index ) ){
                
                $this->query->whereRaw( DB::Raw( 'FIND_IN_SET(' . $this->foreignKey . ',"' .$this->getParentKey() .'")'));
            }else{

                $this->query->whereRaw( DB::Raw( 'FIND_IN_SET(' . $this->foreignKey . ',"' .$this->getParentKey() .'") = ' . $this->index));
            }
            
            // $this->query->orWhereNull($this->foreignKey);
        }
    }
}
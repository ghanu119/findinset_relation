<?php
namespace GhanuZ\FindInSet;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class FindInSetRelation extends HasMany {

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
            
            $this->query->whereRaw(  'FIND_IN_SET(' . $this->foreignKey . ',"' .$this->getParentKey() .'")');
        }
    }

        /**
     * Set the constraints for an eager load of the relation.
     *
     * @param  array  $models
     * @return void
     */
    public function addEagerConstraints(array $models)
    {
        
        // $this->query->addSelect('*', DB::raw('"' . $this->getKeys($models, $this->localKey)[0] . '" as __id') );
        $this->query->whereRaw( 'FIND_IN_SET(' . $this->foreignKey . ', "' . implode( ',', $this->getKeys($models, $this->localKey) ) .'" )');
    }

    /**
     * Build model dictionary keyed by the relation's foreign key.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @return array
     */
    protected function buildDictionary(Collection $results, $localKey = null)
    {
        $foreign = $this->getForeignKeyName();

        $localKeyArr = explode(',', $localKey );
        return $results->mapToDictionary(function ($result) use ($foreign, $localKeyArr, $localKey) {
            
            if( is_null( $this->index ) ){
                if( in_array( $result->{$foreign}, $localKeyArr )){
                    return [$localKey => $result];    
                }
            }else{
                $i = $this->index - 1 ;
                if( $i > 0 && !empty( $localKeyArr[ $i ] ) && $result->{$foreign} == $localKeyArr[ $i ] ){
                    return [$localKey => $result];    
                }
            }
            return [$this->getDictionaryKey($result->{$foreign}) => $result];
        })->all();
    }

    protected function matchOneOrMany(array $models, Collection $results, $relation, $type)
    {
        // $dictionary = $this->buildDictionary($results);

        // Once we have the dictionary we can simply spin through the parent models to
        // link them up with their children using the keyed dictionary to make the
        // matching very convenient and easy work. Then we'll just return them.
        foreach ($models as $model) {
            $dictionary = $this->buildDictionary($results, $model->getAttribute($this->localKey));
            if (isset($dictionary[$key = $this->getDictionaryKey( $model->getAttribute($this->localKey) )])) {
                $model->setRelation(
                    $relation, $this->getRelationValue($dictionary, $key, $type)
                );
            }
        }

        return $models;
    }
}

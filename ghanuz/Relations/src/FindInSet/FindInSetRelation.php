<?php
namespace GhanuZ\FindInSet;

use Illuminate\Database\Eloquent\Collection;
use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use DB;

class FindInSetRelation extends HasMany {

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
        $this->query->addSelect('*', DB::raw('"' . $this->getKeys($models, $this->localKey)[0] . '" as __id') );
        $this->query->whereRaw( 'FIND_IN_SET(' . $this->foreignKey . ', "' .$this->getKeys($models, $this->localKey)[0] .'" )');
    }

    /**
     * Build model dictionary keyed by the relation's foreign key.
     *
     * @param  \Illuminate\Database\Eloquent\Collection  $results
     * @return array
     */
    protected function buildDictionary(Collection $results)
    {
        $foreign = '__'.$this->getForeignKeyName();

        return $results->mapToDictionary(function ($result) use ($foreign) {
            return [$result->{$foreign} => $result];
        })->all();
    }
}
